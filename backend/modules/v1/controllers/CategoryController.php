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
 	private $_cateSer;    //分类管理

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
        		$item['contId'] = $value->id;
        		$item['styleId'] = $value->style_id;
        		$item['styleName'] = $value->artsStyles->style_name;
        		$item['contName'] = $value->content_name;
        		$item['contSort'] = $value->content_sort;
        		$item['contState'] = $value->content_state;
        		$item['contStateName'] = $value->contentStateNameBox[$value->content_state];
        		$item['contDesc'] = $value->content_desc;
        		$item['updateAt'] = $value->update_at;
        		$data[] = $item;
        	}
        }
        $pageInfo['list'] = $data;
        return $this->success($pageInfo);
	}

	/**
	 * 内容分类详情
	 * @param  $contId
	 */
	public function actionContentsDetail()
	{
		$contId = \Yii::$app->request->post('contId');
		if (!$contId) {
			return $this->error('1001');
		}
		$info = $this->_cateSer->getContentCateDetail($contId);
		if (empty($info)) {
			return $this->error('1014');
		}
		$item['contId'] = $info->id;
		$item['styleId'] = $info->style_id;
		$item['styleName'] = $info->artsStyles->style_name;
		$item['contName'] = $info->content_name;
		$item['contSort'] = $info->content_sort;
		$item['contState'] = $info->content_state;
		$item['contStateName'] = $info->contentStateNameBox[$info->content_state];
		$item['contDesc'] = $info->content_desc;
		$item['updateAt'] = $info->update_at;
		return $this->success($item);
	}

	/**
	 * 新增/编辑内容分类
	 * @param  $contId
	 * @param  $styleId
	 * @param  $contName
	 * @param  $contSort
	 * @param  $contState
	 * @param  $contDesc
	 */
	public function actionContentsSet()
	{
		$contId = \Yii::$app->request->post('contId',0);
		$styleId = \Yii::$app->request->post('styleId',0);
		$contName = \Yii::$app->request->post('contName');
		$contSort = \Yii::$app->request->post('contSort');
		$contState = \Yii::$app->request->post('contState');
		$contDesc = \Yii::$app->request->post('contDesc');

		if (strlen($contName) < 1) {
			return $this->error('1001');
		}

		$res = $this->_cateSer->setContentCateDetail($styleId, $contName, $contSort, $contState, $contDesc, $contId);
		if ($res) {
			return $this->success('修改成功');
		} else {
			return $this->error('1003');
		}
	}

	/**
	 * 删除内容分类
	 * @param  $contId
	 * @return  bool
	 */
	public function actionContentsDel()
	{
		$contId = \Yii::$app->request->post('contId');
		if (!$contId) {
			return $this->error('1001');
		}
		$res = $this->_cateSer->delContentCate($contId);
		if ($res) {
			return $this->success('禁用内容分类成功');
		} else {
			return $this->error('1003');
		}
	}

	/**
	 * 颜色列表
	 * @param  $page  分页
	 * @param  $limit  每页条数
	 */
	public function actionColorsList()
	{
		$page = \Yii::$app->request->post('page',1);
        $limit = \Yii::$app->request->post('limit',20);

        $offset = ($page - 1) * $limit;
        $count = $this->_cateSer->getColorCount();
        $pageInfo = $this->getPageInfo($page, $limit, $count);
        // 列表
        $list = $this->_cateSer->getColorList($limit, $offset);
        $data = [];
        if (!empty($list)) {
        	foreach ($list as $key => $value) {
	       		$item = [];
        		$item['colorId'] = $value->id;
        		$item['colorName'] = $value->color_name;
        		$item['colorSort'] = $value->color_sort;
        		$item['colorState'] = $value->color_state;
        		$item['colorStateName'] = $value->colorStateNameBox[$value->color_state];
        		$item['colorDesc'] = $value->color_desc;
        		$item['colorCode'] = $value->color_code;
        		$item['colorImage'] = CommonService::getImageUrl($value->color_image);
        		$item['updateAt'] = $value->update_at;
        		$data[] = $item;
        	}
        }
        $pageInfo['list'] = $data;
        return $this->success($pageInfo);
	}

	/**
	 * 颜色详情
	 * @param  $colorId  颜色编号
	 */
	public function actionColorsDetail()
	{
		$colorId = \Yii::$app->request->post('colorId');
		if (!$colorId) {
			return $this->error('1001');
		}
		$info = $this->_cateSer->getColorDetail($colorId);
		if (empty($info)) {
			return $this->error('1015');
		}
		$item['colorId'] = $info->id;
		$item['colorName'] = $info->color_name;
		$item['colorSort'] = $info->color_sort;
		$item['colorState'] = $info->color_state;
		$item['colorStateName'] = $info->colorStateNameBox[$info->color_state];
		$item['colorDesc'] = $info->color_desc;
		$item['colorCode'] = $info->color_code;
		$item['colorImage'] = CommonService::getImageUrl($info->color_image);
		$item['updateAt'] = $info->update_at;
		return $this->success($item);
	}

	/**
	 * 新增/编辑颜色
	 * @param  $colorId
	 * @param  $colorName
	 * @param  $colorSort
	 * @param  $colorState
	 * @param  $colorDesc
	 * @param  $colorCode
	 * @param  $colorImage
	 */
	public function actionColorsSet()
	{
		$colorId = \Yii::$app->request->post('colorId',0);
		$colorName = \Yii::$app->request->post('colorName');
		$colorSort = \Yii::$app->request->post('colorSort');
		$colorState = \Yii::$app->request->post('colorState');
		$colorDesc = \Yii::$app->request->post('colorDesc');
		$colorCode = \Yii::$app->request->post('colorCode');
		$colorImage = \Yii::$app->request->post('colorImage');

		if (strlen($colorName) < 1) {
			return $this->error('1001');
		}

		$res = $this->_cateSer->setColorDetail($colorName, $colorSort, $colorState, $colorDesc, $colorCode, $colorImage, $colorId);
		if ($res) {
			return $this->success('修改成功');
		} else {
			return $this->error('1003');
		}
	}

	/**
	 * 删除颜色
	 * @param  $colorId
	 */
	public function actionColorsDel()
	{
		$colorId = \Yii::$app->request->post('colorId');
		if (!$colorId) {
			return $this->error('1001');
		}
		$res = $this->_cateSer->delColor($colorId);
		if ($res) {
			return $this->success('修改成功');
		} else {
			return $this->error('1003');
		}
	}
 }