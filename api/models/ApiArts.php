<?php
namespace api\models;

use Yii;
use yii\db\Exception;
use common\models\Arts;
use common\services\CommonService;

/**
 * 图片数据处理
 */
class ApiArts extends Arts
{
	// 常量定义
	const ART_DELETE = 0;
	const ART_USEFUL = 1;
	
	/**
	 * 条件查询图片数量
	 * @param  $class  类型
	 * @param  $style  风格
	 * @param  $content  内容
	 * @param  $color  颜色
	 */
	public function getArtCount($param=[])
	{
		$count = self::find()->from(['a'=>self::tableName()]);
		if (isset($param['color']) && !empty($param['color'])) {
			$count->joinWith(['artsColorsRels ac' => function($q){
				$q->joinWith(['artsColors c']);
				$q->onCondition(['ac.state'=>self::ART_USEFUL]);
			}]);
		}
		if (isset($param['class']) && $param['class']) {
			$count->andWhere(['a.class_id'=>$param['class']]);
		}
		if (isset($param['style']) && $param['style']) {
			$count->andWhere(['a.style_id'=>$param['style']]);
		}
		if (isset($param['content']) && $param['content']) {
			$count->andWhere(['a.cont_id'=>$param['content']]);
		}
		$count->andWhere(['a.state'=>self::ART_USEFUL]);
		return $count->count();
	}

	/**
	 * 条件查询图片
	 */
	public function getArtList($param=[], $offset=0, $limit=20)
	{
		$list = self::find()->from(['a'=>self::tableName()]);
		$list->joinWith(['coverImg cg']);
		if (isset($param['color']) && !empty($param['color'])) {
			$list->joinWith(['artsColorsRels ac' => function($q){
				$q->joinWith(['artsColors c']);
				$q->onCondition(['ac.state'=>self::ART_USEFUL]);
			}]);
		}
		if (isset($param['class']) && $param['class']) {
			$list->andWhere(['a.class_id'=>$param['class']]);
		}
		if (isset($param['style']) && $param['style']) {
			$list->andWhere(['a.style_id'=>$param['style']]);
		}
		if (isset($param['content']) && $param['content']) {
			$list->andWhere(['a.cont_id'=>$param['content']]);
		}
		$list->andWhere(['a.state'=>self::ART_USEFUL]);
		$list->orderBy('sort DESC,id DESC');
		return $list->offset($offset)->limit($limit)->all();
	}

}