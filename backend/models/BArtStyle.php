<?php
namespace backend\models;

use common\models\ArtStyle;

class BArtStyle extends ArtStyle
{
	const ART_STYLE_DELETE = 0;
	const ART_STYLE_USEFUL = 1;

	/**
	 * 样式缓存
	 */
	public static function getArtStyles()
	{
		$cache = \Yii::$app->cache;
		$key = '_ART_STYLE_';
		if ($cache->get($key) === false) {
			$items = self::find()->where(['status'=>self::ART_STYLE_USEFUL])->all();
			if (empty($items)) {
				return [];
			}
			foreach ($items as $key => $value) {
				$styles[$value->id] = $value;
			}
			$cache->set($key,$styles,60);
			return $styles;
		} else {
			return $cache->get($key);
		}
	}
}