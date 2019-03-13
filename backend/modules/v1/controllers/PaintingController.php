<?php
namespace backend\modules\v1\controllers;

use backend\controllers\ApiBaseController;
use backend\services\ArtService;
use backend\services\MemberService;
use common\services\CommonServer;
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
        $this->_memberSer = new MemberService();
    }

	/**
	 * 图片列表
	 * @param  $picName  图片名称
	 * @param  $picNo  图片编号
	 * @param  $classId  类型分类
	 * @param  $styleId  风格分类
	 * @param  $contId  内容分类
	 * @param  $colorId  颜色
	 * @param  $page
	 * @param  $limit
	 */
	public function actionPicList()
	{
		$page = \Yii::$app->request->post('page',1);
        $limit = \Yii::$app->request->post('limit',20);
        // 查询条件
        $picName = \Yii::$app->request->post('picName','');
        $picNo = \Yii::$app->request->post('picNo','');
        $classId = \Yii::$app->request->post('classId',0);
        $styleId = \Yii::$app->request->post('styleId',0);
        $contId = \Yii::$app->request->post('contId',0);
        $colorId = \Yii::$app->request->post('colorId',0);
        $selected = [
        	'picName' => $picName,
        	'picNo' => $picNo,
        	'classId' => $classId,
        	'styleId' => $styleId,
        	'contId' => $contId,
        	'colorId' => $colorId,
        ];

        $count = $this->_artSer->getArtsCount($classId,$styleId,$contId,$colorId,$picName,$picNo);
        $pageInfo = $this->getPageInfo($page, $limit, $count);
        $offset = ($pageInfo['page'] - 1) * $limit;
        // 列表
        $list = $this->_artSer->getArtsList($limit, $offset, $classId, $styleId, $contId, $colorId, $picName, $picNo);
        $data = [];
        if (!empty($list)) {
        	foreach ($list as $key => $value) {
        		# code...
        		$item = [];
        		$item['picId'] = $value->id;
        		$item['picName'] = $value->art_title;
        		$item['picNo'] = $value->art_no;
        		$item['authorId'] = $value->author_id;
        		$authorInfo = $this->_memberSer->getAuthorInfoById($value->author_id);
        		$item['authorName'] = isset($authorInfo->author_name) ? $authorInfo->author_name : '';
        		$item['classId'] = $value->art_class;
        		$className = $this->_artSer->getArtClassName($value->art_class);
        		$item['className'] = $className;
        		$item['styleId'] = $value->art_style;
        		$styleName = $this->_artSer->getArtStyleName($value->art_style);
        		$item['styleName'] = $styleName;
        		$item['contentId'] = $value->art_content;
        		$contName = $this->_artSer->getArtContentName($value->art_content);
        		$item['contentName'] = $contName;
        		$item['colorId'] = $value->art_color;
        		$colorInfo = $this->_artSer->getArtColorInfo($value->art_color);
        		$item['colorName'] = isset($colorInfo->color_name) ? $colorInfo->color_name : '';
        		$item['colorCode'] = isset($colorInfo->color_code) ? $colorInfo->color_code : '';
        		$item['length'] = $value->art_length;
        		$item['width'] = $value->art_width;
        		$item['size'] = $value->art_size;
        		$item['dpi'] = $value->art_dpi;
        		$item['mark'] = $value->mark;
        		$item['desc'] = $value->desc;
        		$item['likes'] = $value->likes;
        		$item['state'] = $value->art_state;
        		$item['stateName'] = $value->artStateNameBox[$value->art_state];
        		$item['showImage'] = CommonServer::getImageUrl($value->show_image);
        		$item['updateAt'] = $value->update_at;
        		$data[] = $item;
        	}
        }
        $pageInfo['list'] = $data;
        // 查询条件
        $pageInfo['selectInfo'] = $selected;
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