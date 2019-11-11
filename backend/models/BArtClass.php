<?php
namespace backend\models;

use common\models\ArtClass;

class BArtClass extends ArtClass
{
	const ART_CLASS_DELETE = 0;
	const ART_CLASS_USEFUL = 1;
	
	/**
	 * 分类缓存
	 */
	public static function getArtClasses()
	{
		$cache = \Yii::$app->cache;
		$key = '_ART_CLASS_';
		if ($cache->get($key) === false) {
			// 全部分类缓存
			$items = self::find()->where(['status'=>self::ART_CLASS_USEFUL])->all();
			if (empty($items)) {
				return [];
			}
			foreach ($items as $key => $value) {
				$classes[$value->id] = $value;
			}
			$cache->set($key, $classes, 60);
			return $classes;
		} else {
			return $cache->get($key);
		}
	}
}