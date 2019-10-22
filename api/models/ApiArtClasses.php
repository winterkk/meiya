<?php
namespace api\models;

use Yii;
use yii\db\Exception;
use common\models\ArtsClasses;
use common\services\CommonService;

/**
 * 分类
 */
class ApiArtClasses extends ArtsClasses
{
	const CLASS_DELETE = 0;
	const CLASS_USEFUL = 1;

	/**
	 * 分类信息
	 * @date  2019-10
	 */
	public function getArtClasses()
	{
		$cache = \Yii::$app->cache;
		$key = 'ART_CLASS_SET';
		$classes = $cache->get($key);
		if ($classes === false) {
			$items = self::find()->from(['c'=>self::tableName()])
				->joinWith(['classImg g'])
				->where(['c.state'=>self::CLASS_USEFUL])
				->orderBy('c.sort DESC')
				->all();
			if (!empty($items)) {
				foreach ($items as $k => $v) {
					$t = [];
					$t['id'] = $v->id;
					$t['title'] = $v->title;
					$cover = isset($v->classImg->path) ? $v->classImg->path : '';
					$cover = CommonService::getImageUrl($cover);
					$t['cover'] = $cover;
					$classes[] = $t;
				}
				$cache->set($key, $classes, 60);
			}
		}
		return $classes;
	}

	/**
	 * 类型分类导航
	 */
	public function getClassNav($id)
	{
		$info = self::getClassIdentity($id);
		$path = [];
		if (!empty($info)) {
			$path = ['classId'=>$id, 'classTitle'=>$info->title];
		}
		return $path;
	}
}