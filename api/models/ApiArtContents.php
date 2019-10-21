<?php
namespace  api\models;

use Yii;
use yii\db\Exception;
use common\models\ArtsContents;
use common\services\CommonService;

/**
 * 内容分类
 */
class ApiArtContents extends ArtsContents
{
	// 状态常量
	const CONTENT_DELETE = 0;
	const CONTENT_USEFUL = 1;

	/**
	 * 全部内容分类
	 */
	public function getArtContents()
	{
		$cache = \Yii::$app->cache;
		$key = "ART_CONTENT_SET1";
		$styles = $cache->get($key);
		if ($styles === false) {
			$list = self::find()->from(['c'=>self::tableName()])
				->joinWith(['contentImg g'])
				->where(['c.state'=>self::CONTENT_USEFUL])
				->orderBy('c.sort DESC')
				->all();
			if (!empty($list)) {
				foreach ($list as $i => $j) {
					$t = [];
					$t['id'] = $j->id;
					$t['styleId'] = $j->style_id;
					$t['title'] = $j->title;
					$cover = isset($j->contentImg->path) ? $j->contentImg->path : '';
					$cover = CommonService::getImageUrl($cover);
					$t['cover'] = $cover;
					$styles[] = $t;
				}
				$cache->set($key, $styles, 60);
			}
		}
		return $styles;
	}

	/**
	 * 单个风格下的内容分类
	 * @param  $styleId
	 */
	public function getArtStyleContents($styleId)
	{
		$arr = [];
		if ($styleId) {
			$list = $this->getArtContents();
			if (!empty($list)) {
				foreach ($list as $key => $value) {
					if ($value['styleId'] == $styleId) {
						$arr[] = $value;
					}
				}
			}
		}
		return $arr;
	}
}