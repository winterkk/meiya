<?php
namespace backend\modules\v1\controllers;

use backend\controllers\ApiBaseController;
use backend\services\ArtService;
use yii;
/**
 * 图片操作类	
 * @date  2019-03
 */
class PaintingController extends ApiBaseController()
{
	public $modelClass = false;

	private $_artSer;    //图片管理

    public function init()
    {
        parent::init();
        $this->_artSer = new ArtService();
    }

	/**
	 * 图片列表
	 * @param  $page
	 * @param  $limit
	 */
	public function actionPicList()
	{
		$page = \Yii::$app->request->post('page',1);
        $limit = \Yii::$app->request->post('limit',20);

        $offset = ($page - 1) * $limit;
        $count = $this->_artSer->getArtsCount();
        $pageInfo = $this->getPageInfo($page, $limit, $count);
        // 列表
        $list = $this->_artSer->getClassesList($limit, $offset);
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
	 * 图片详情
	 * @param  $picId
	 */
	public function actionPicDefault()
	{
		$picId = \Yii::$app->request->post('picId');
	}

	/**
	 * 新增/编辑图片
	 *
	 */
	public function actionPicSet()
	{

	}

	/**
	 * 删除图片
	 *
	 */
	public function actionPicDel()
	{

	}

	/**
	 * 作者的图片列表
	 *
	 *
	 */
	public function actionAuthorPicList()
	{

	}
}