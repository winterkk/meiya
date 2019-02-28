<?php
namespace backend\modules\v1\controllers;

use backend\controllers\ApiBaseController;
use backend\services\CategoryService;
use yii;
/**
 * 分类信息操作
 * @date  2019-02
 */

 class CategoryController extends ApiBaseController
 {
 	public $modelClass = false;
 	private $_cateSer;    //人员管理对象

    public function init()
    {
        parent::init();
        $this->_cateSer = new CategoryService();
    }

 	/**
 	 * 类型分类列表
 	 * @param  $page  页码
 	 * @param  $limit  每页条数
 	 * @return  array
 	 */
 	public function actionClassesList()
 	{
 		$page = \Yii::$app->request->post('page',1);
        $limit = \Yii::$app->request->post('limit',20);

        $offset = ($page - 1) * $limit;
        $count = $this->_cateSer->getClassesCount();
        $pageInfo = $this->getPageInfo($page, $limit, $count);
        // 列表
        $list = $this->_cateSer->getClassesList($limit, $offset);
        $data = [];
        if (!empty($list)) {
        	foreach ($list as $key => $value) {
        		# code...
        		$item = [];
        		$item['classId'] = $value->id;
        		$item['className'] = $value->class_name;
        		$item['classDesc'] = $value->class_desc;
        		$item['classState'] = $value->class_state;
        		$item['classStateName'] = $value->classStateNameBox[$value->class_state];
        		$item['updateAt'] = $value->update_at;
        		$data[] = $item;
        	}
        }
        $pageInfo['list'] = $data;
        return $this->success($pageInfo);
 	}

 	/**
 	 * 类型分类详情
 	 * @param  $classId
 	 */
 	public function actionClassesDetail()
 	{
 		$classId = \Yii::$app->request()->param('classId');
 		if (!$classId) {
 			return $this->error('1001');
 		}
 		$info = $this->_cateSer->getClassDetailInfo($classId);
 		if (empty($info)) {
 			return $this->error('1011');
 		}
 		$data = [];
 		$data['classId'] = $info->id;
 		$data['className'] = $info->class_name;
 		$data['classSort'] = $info->class_sort;
 		$data['classDesc'] = $info->class_desc;
 		$data['classState'] = $info->class_state;
 		$data['classStateName'] = $info->classStateNameBox[$info->class_state];
 		$data['updateAt'] = $info->update_at;
 		return $this->success($data);
 	} 

 	/**
 	 * 新增/编辑类型分类
 	 * @param  $classId  分类id
 	 * @param  $name  
 	 * @param  $sort
 	 * @param  $desc
 	 * @param  $state
 	 * @return  bool
 	 */
 	public function actionClassesSet()
 	{
 		$classId = \Yii::$app->request->post('classId',0);
 		$name = \Yii::$app->request->post('name');
 		$sort = \Yii::$app->request->post('sort');
 		$desc = \Yii::$app->request->post('desc');
 		$desc = \Yii::$app->request->post('state');

 		$res = $this->_cateSer->setArtClassInfo($classId,$name,$sort,$desc,$state);
 		if ($res) {
 			return $this->success('新建或编辑成功!');
 		} else {
 			return $this->error('1003');
 		}
 	}

 	/**
 	 * 删除类型分类
 	 * @param  $classId
 	 */
 	public function actionClassesDel()
 	{
 		$classId = \Yii::$app->request->post('classId');
 		$res = $this->_cateSer->delArtClass($classId);
 		if ($res) {
 			return $this->success('禁用成功！');
 		} else {
 			return $this->error('1012');
 		}
 	}

 	/**
 	 * 风格分类列表
 	 * @param  $page
 	 * @param  $limit
 	 * @param  $classId
 	 */
 	public function actionStylesList()
	{
		$page = \Yii::$app->request->post('page',1);
        $limit = \Yii::$app->request->post('limit',20);
        $classId = \Yii::$app->request->post('classId',0);

        $offset = ($page - 1) * $limit;
        $count = $this->_cateSer->getStylesCateCount($classId);
        $pageInfo = $this->getPageInfo($page, $limit, $count);
        // 列表
        $list = $this->_cateSer->getStylesCateList($classId, $limit, $offset);
        $data = [];
        if (!empty($list)) {
        	foreach ($list as $key => $value) {
        		# code...
	       		$item = [];
        		$item['styleId'] = $value->id;
        		$item['classId'] = $value->class_id;
        		$item['className'] = $value->artsClasses->class_name;
        		$item['styleName'] = $value->style_name;
        		$item['styleSort'] = $value->style_sort;
        		$item['styleState'] = $value->style_state;
        		$item['styleStateName'] = $value->styleStateNameBox[$value->style_state];
        		$item['styleDesc'] = $value->style_desc;
        		$item['updateAt'] = $value->update_at;
        		$data[] = $item;
        	}
        }
        $pageInfo['list'] = $data;
        return $this->success($pageInfo);
	}

	/**
	 * 风格分类详情
	 * @param  $styleId
	 */
	public function actionStylesDetail()
	{
		$styleId = \Yii::$app->request->post('styleId');
		if (!$styleId) {
			return $this->error('1001');
		}

		$info = $this->_cateSer->getArtStyleDetail($styleId);
		if (empty($info)) {
			return $this->error('1011');
		}
		$item = [];
		$item['styleId'] = $info->id;
		$item['classId'] = $info->class_id;
		$item['className'] = $info->artsClasses->class_name;
		$item['styleName'] = $info->style_name;
		$item['styleSort'] = $info->style_sort;
		$item['styleState'] = $info->style_state;
		$item['styleStateName'] = $info->styleStateNameBox[$info->style_state];
		$item['styleDesc'] = $info->style_desc;
		$item['updateAt'] = $info->update_at;
		return $this->success($item);
	}

	/**
	 * 模糊查询类型分类
	 * @param  $cateName  类型分类名称
	 */
	public function actionGetArtClassByName()
	{
		$cateName = \Yii::$app->request->post('cateName');
		if (strlen($cateName) < 1) {
			return $this->error('1013');
		}
		$list = $this->_cateSer->searchClassByName($cateName);
		$data = [];
		if (!empty($list)) {
			foreach ($list as $key => $value) {
				# code...
				$item = [];
				$item['id'] = $value->id;
				$item['name'] = $value->class_name;
				$data[] = $item;
			}
		}

		return $this->success($data);
	}

	/**
	 * 新增/编辑风格分类
	 * @param  $styleId
	 * @param  $classId  类型分类id
	 * @param  $name 
	 * @param  $sort
	 * @param  $state
	 * @param  $desc
	 */
	public function actionStylesSet()
	{
		$styleId = \Yii::$app->request->post('styleId',0);
		$classId = \Yii::$app->request->post('classId');
		$styleName = \Yii::$app->request->post('name');
		$styleSort = \Yii::$app->request->post('sort');
		$styleState = \Yii::$app->request->post('state');
		$styleDesc = \Yii::$app->request->post('desc');

		$res = $this->_cateSer->setCateStyleInfo($classId,$styleName,$styleSort,$styleState,$styleDesc,$styleId);
		if ($res) {
			return $this->success('新建或编辑成功!');
		} else {
			return $this->error('1003');
		}
	}

	/**
	 * 删除风格分类
	 * @param  $styleId
	 * @return  bool
	 */
	public function actionStylesDel()
	{
		$styleId = \Yii::$app->request->post('styleId');
		if (!$styleId) {
			return $this->error('1001');
		}
		$res = $this->_cateSer->delCateStyle($styleId);
		if ($res) {
			return $this->success('禁用风格分类成功');
		} else {
			return $this->error('1003');
		}
	}

	/**
	 * 内容分类列表
	 * @param  $styleId  风格分类id
	 * @param  $page
	 * @param  $limit
	 */
	public function actionContentsList()
	{
		$page = \Yii::$app->request->post('page',1);
        $limit = \Yii::$app->request->post('limit',20);
        $styleId = \Yii::$app->request->post('styleId',0);

        $offset = ($page - 1) * $limit;
        $count = $this->_cateSer->getContentCateCount($styleId);
        $pageInfo = $this->getPageInfo($page, $limit, $count);
        // 列表
        $list = $this->_cateSer->getContentCateList($styleId, $limit, $offset);
        $data = [];
        if (!empty($list)) {
        	foreach ($list as $key => $value) {
        		# code...
	       		$item = [];
        		$item['contentId'] = $value->id;
        		$item['styleId'] = $value->style_id;
        		$item['styleName'] = $value->artsStyles->style_name;
        		$item['contentName'] = $value->content_name;
        		$item['contentSort'] = $value->content_sort;
        		$item['contentState'] = $value->content_state;
        		$item['contentStateName'] = $value->contentStateNameBox[$value->content_state];
        		$item['contentDesc'] = $value->content_desc;
        		$item['updateAt'] = $value->update_at;
        		$data[] = $item;
        	}
        }
        $pageInfo['list'] = $data;
        return $this->success($pageInfo);
	}

	/**
	 * 内容分类详情
	 *
	 */
	public function actionContentsDetail()
	{

	}

	/**
	 * 新增/编辑内容分类
	 *
	 */
	public function actionContentsSet()
	{

	}

	/**
	 * 删除内容分类
	 *
	 */
	public function actionContentsDel()
	{

	}

	/**
	 * 颜色列表
	 *
	 */
	public function actionColorsList()
	{

	}

	/**
	 * 颜色详情
	 *
	 */
	public function actionColorsDetail()
	{

	}

	/**
	 * 新增/编辑颜色
	 *
	 */
	public function actionColorsSet()
	{

	}

	/**
	 * 删除颜色
	 *
	 */
	public function actionColorsDel()
	{

	}
 }