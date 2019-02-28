<?php
namespace backend\services;

/**
 * 分类信息管理类
 * @date  2019-02
 */

use common\services\CommonService;
use common\models\Admins;
use common\models\AdminsLog;
use common\models\ArtsClasses;
use common\models\ArtsStyles;
use common\models\ArtsContents;

class CategoryService extends CommonService
{
	/**
	 * 类型分类总数
	 * @param
	 * @return  number
	 * @date  2019-02
	 */
	public function getClassesCount()
	{
		return ArtsClasses::find()->where(['>','class_state',ArtsClasses::CLASS_STATE_DEL])->count();
	}

	/**
	 * 类型分类列表
	 * @param  $limit
	 * @param  $offset
	 * @return  object
	 * @date  2019-02
	 */
	public function getClassesList($limit=20, $offset=0)
	{
		return ArtsClasses::find()->where(['>','class_state',ArtsClasses::CLASS_STATE_DEL])
			->limit($limit)
			->offset($offset)
			->all();
	}

	/**
	 * 类型Id
	 * @param  $cateId  类型id
	 * @return  object
	 * @date  2019-02
	 */
	public function getClassDetailInfo($cateId)
	{
		return ArtsClasses::findOne($cateId);
	}

	/**
	 * 新增/编辑类型分类
	 * @param  $cateId
	 * @param  $name
	 * @param  $sort
	 * @param  $desc
	 * @param  $state
	 * @return  bool
	 */
	public function setArtClassInfo($cateId=0,$name,$sort,$desc,$state)
	{
		if (!$cateId) {
			$mod = new ArtsClasses();
			$state = ArtsClasses::CLASS_STATE_USABLE;
		} else {
			$mod = ArtsClasses::findOne($cateId);
			if (empty($mod)) {
				return false;
			}
			$state = isset($mod->classStateNameBox[$state]) ? $state : ArtsClasses::CLASS_STATE_USABLE;
		}
		$mod->class_name = $name;
		$mod->class_sort = $sort;
		$mod->class_desc = $desc;
		$mod->class_state = $state;
		$mod->update_at = date('Y-m-d H:i:s');
		return $mod->save();
	}

	/**
	 * 禁用类型分类
	 * @param  $cateId
	 * @return  bool
	 */
	public function delArtClass($cateId)
	{
		$cateInfo = ArtsClasses::findOne($cateId);
		if (!empty($cateInfo)) {
			if ($cateInfo->state != ArtsClasses::CLASS_STATE_DISABLE) {
				$cateInfo->state = ArtsClasses::CLASS_STATE_DISABLE;
				return $cateInfo->save();
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 风格分类总数查询
	 * @param  $classId  类型id
	 * @return  number
	 */
	public function getStylesCateCount($classId=0)
	{
		$count = ArtsStyles::find()
			->where(['>','style_state',ArtsStyles::STYLE_STATE_DEL]);
		if ($classId > 0) {
			$count->andWhere(['class_id' => $classId]);
		}
		return $count->count();
	}

	/**
	 * 风格分类列表
	 * @param  $classId  类型分类id
	 * @param  $limit
	 * @param  $offset
	 */
	public function getStylesCateList($classId = 0, $limit = 20, $offset = 0)
	{
		$list = ArtsStyles::find()
			->from(['s'=>ArtsStyles::tableName()])
			->joinWith(['artsClasses c'])
			->where(['>','s.style_state',ArtsStyles::STYLE_STATE_DEL]);
		if ($classId > 0) {
			$list->andWhere(['s.class_id' => $classId]);
		}
		return $list->limit($limit)->offset($offset)->all();
	}

	/**
	 * 风格分类详情
	 * @param  $styleId
	 */
	public function getArtStyleDetail($styleId)
	{
		return ArtsStyles::find()
			->from(['s'=>ArtsStyles::tableName()])
			->joinWith(['artsClasses c'])
			->where(['>','s.style_state',ArtsStyles::STYLE_STATE_DEL])
			->one();
	}

	/**
	 * 类型名称搜索
	 * @param  $cateName
	 * @param  list
	 */
	public function searchClassByName($cateName)
	{
		return ArtsClasses::find()
			->where(['class_state'=>CLASS_STATE_USABLE])
			->andWhere(['like','class_name',$cateName])
			->all();
	}

	/**
	 * 新建/修改风格分类
	 * @param  $classId  类型id
	 * @param  $styleName  风格名称
	 * @param  $styleSort
	 * @param  $styleState  新建默认可用
	 * @param  $styleDesc 
	 * @param  $styleId  风格id
	 * @return  bool
	 */
	public function setCateStyleInfo($classId,$styleName,$styleSort,$styleState,$styleDesc,$styleId=0)
	{
		if (!$styleId) {
			$info = new ArtsStyles();
			$info->style_state = ArtsStyles::STYLE_STATE_USABLE;
			$info->create_at = date('Y-m-d H:i:s');
		} else {
			$info = ArtsStyles::findOne($styleId);
			if (isset($info->styleStateNameBox[$styleState])) {
				$info->style_state = $style_state;
			}
		}
		// 内容过滤
		$styleDesc = CommonService::simpleTransfer($styleDesc);
		if (!CommonService::selectBadWords($styleDesc)) {
			$styleDesc = '';
		}
		if (!CommonService::selectBadWords($styleName)) {
			\Yii::error('出现垃圾词:'.$styleName);
			return false;
		}
		if (empty($info)) {
			return false;
		}
		$info->class_id = $classId;
		$info->style_name = $styleName;
		$info->style_sort = $styleSort;
		$info->style_desc = $styleDesc;

		return $info->save();
	}

	/**
	 * 禁用风格分类
	 * @param  $styleId 
	 * @return  bool
	 */
	public function delCateStyle($styleId)
	{
		$info = ArtsStyles::findOne($styleId);
		if (!empty($info)) {
			if ($info->style_state == ArtsStyles::STYLE_STATE_USABLE) {
				return true;
			} else {
				$info->style_state = ArtsStyles::STYLE_STATE_USABLE;
				return $info->save();
			}
		} else {
			return false;
		}
	}

	/**
	 * 内容分类统计总数
	 * @param  $styleId  风格分类id
	 * @return  number
	 */
	public function getContentCateCount($styleId=0)
	{
		$count = ArtsContents::find()->where(['>','content_state',ArtsContents::CONTENT_STATE_DEL]);
		if ($styleId > 0) {
			$count->andWhere(['style_id'=>$styleId]);
		}
		return $count->count();
	}

	/**
	 * 内容分类列表
	 * @param  $styleId  风格分类id
	 */
	public function getContentCateList($styleId=0, $limit, $offset)
	{
		$list = ArtsContents::find()->where(['>','content_state',ArtsContents::CONTENT_STATE_DEL]);
		if ($styleId > 0) {
			$list->andWhere(['style_id'=>$styleId]);
		}
		return $list->limit($limit)->offset($offset)->all();
	}
}