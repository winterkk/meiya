<?php
namespace backend\ArtService;

use common\services\CommonService;
use common\models\Arts;
use common\models\ArtsClasses;
use common\models\ArtsStyles;
use common\models\ArtsContents;
use common\models\ArtsColors;

/**
 * 图片操作类
 * @date  2019-03
 */

class ArtService extends CommonService
{
	/**
	 * 条件查询图片数量
	 * @param  $classId  类型分类
	 * @param  $styleId  风格分类
	 * @param  $contId  内容分类
	 * @param  $colorId  颜色类型
	 * @param  $picName  图片名称
	 * @param  $picNo  图片编号
	 * @return  number
	 */
	public function getArtsCount($classId=0,$styleId=0,$contId=0,$colorId=0,$picName='',$picNo='')
	{
		$count = Arts::find()->where(['>','art_state',Arts::ART_STATE_DEL]);
		if ($classId) {
			$count->andWhere(['art_class'=>$classId]);
		}
		if ($styleId) {
			$count->andWhere(['art_style'=>$styleId]);
		}
		if ($contId) {
			$count->andWhere(['art_content'=>$contId]);
		}
		if ($colorId) {
			$count->andWhere(['art_color'=>$colorId]);
		}
		if ($picName) {
			$count->andWhere(['like','art_title',$picName]);
		}
		if ($picName) {
			$count->andWhere(['like','art_no',$picNo]);
		}
		return $count->count();
	}

	/**
	 * 图片分页数据
	 * @param  $limit  每页条数
	 * @param  $offset  开始位置
	 * @param  $classId  类型分类
	 * @param  $styleId  风格分类
	 * @param  $contId  内容分类
	 * @param  $colorId  颜色类型
	 * @param  $picName  图片名称
	 * @param  $picNo  图片编号
	 */
	public function getArtsList($limit=20,$offset=0,$classId=0,$styleId=0,$contId=0,$colorId=0,$picName='',$picNo='')
	{
		$list = Arts::find()
			->from(['a'=>Arts::tableName()])
			->joinWith(['artsImages g'])
			->joinWith(['artsColors c'])
			->where(['>','a.art_state',Arts::ART_STATE_DEL]);
		// 查询条件
		if ($classId) {
			$count->andWhere(['a.art_class'=>$classId]);
		}
		if ($styleId) {
			$count->andWhere(['a.art_style'=>$styleId]);
		}
		if ($contId) {
			$count->andWhere(['a.art_content'=>$contId]);
		}
		if ($colorId) {
			$count->andWhere(['a.art_color'=>$colorId]);
		}
		if ($picName) {
			$count->andWhere(['like','a.art_title',$picName]);
		}
		if ($picName) {
			$count->andWhere(['like','a.art_no',$picNo]);
		}
		return $list->limit($limit)->offset($offset)->all();
	}

	/**
	 * 获取画作分类名称
	 * @param  $id
	 * @return  string
	 */
	public function getArtClassName($id)
	{
		$info = ArtsClasses::getArtClassInfo($id);
		return empty($info) ? '' : $info->class_name;
	}

	/**
	 * 获取图片风格分类名
	 * @param  $id
	 * @return string
	 */
	public function getArtStyleName($id)
	{
		$info = ArtsStyles::getArtStyleInfo($id);
		return empty($info) ? '' : $info->style_name;
	}

	/**
	 * 获取内容分类名称
	 * @param  $id
	 * @return  string
	 */
	public function getArtContentName($id)
	{
		$info = ArtsContents::getArtContentInfo($id);
		return empty($info) ? '' : $info->content_name;
	}

	/**
	 * 获取图片颜色信息
	 * @param  $colorId
	 * @return  object
	 */
	public function getArtColorInfo($colorId)
	{
		return ArtsColors::find()->where(['id'=>$colorId,'color_state'=>ArtsColors::COLOR_STATE_USABLE])->one();
	}
}