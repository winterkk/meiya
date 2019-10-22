<?php
namespace api\models;

use Yii;
use yii\db\Exception;
use common\models\ArtsStyles;
use common\services\CommonService;

/**
 * 风格分类
 */
class ApiArtStyles extends ArtsStyles
{
	// 状态常量
	const STYLE_DELETE = 0;
	const STYLE_USEFUL = 1;

	/**
	 * 所有样式
	 * @date  2019-10
	 */
	public function getArtStyles()
	{
		$cache = \Yii::$app->cache;
		$key = "ART_STYLE_SET";
		$styles = $cache->get($key);
		if ($styles === false) {
			$list = self::find()->from(['s'=>self::tableName()])
				->joinWith(['styleImg g'])
				->where(['s.state'=>self::STYLE_USEFUL])
				->orderBy('s.sort DESC')
				->all();
			if (!empty($list)) {
				foreach ($list as $i => $j) {
					$t = [];
					$t['id'] = $j->id;
					$t['classId'] = $j->class_id;
					$t['title'] = $j->title;
					$cover = isset($j->styleImg->path) ? $j->styleImg->path : '';
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
	 * 单个分类下样式
	 */
	public function getArtClassStyles($classId)
	{
		$arr = [];
		if ($classId) {
			$list = $this->getArtStyles();
			if (!empty($list)) {
				foreach ($list as $key => $value) {
					if ($value['classId'] == $classId) {
						$arr[] = $value;
					}
				}
			}
		}
		return $arr;
	}

	/** 
	 * 样式导航
	 */
	public function getStyleNav($id)
	{
		$info = self::find()->from(['s'=>self::tableName()])->joinWith(['artsClasses c'])->one();
		$path = [];
		if (!empty($info) && !empty($info->artsClasses)) {
			$path = [
				'classId' => $info->artsClasses->id,
				'classTitle' => $info->artsClasses->title,
				'_child' => [
					'styleId' => $info->id,
					'styleTitle' => $info->title
				]
			];
		}
		return $path;
	}
}