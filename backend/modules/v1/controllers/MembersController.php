<?php
namespace backend\modules\v1\controllers;

use backend\controllers\ApiBaseController;
use backend\services\MemberService;

/**
 * 人员管理类
 * 
 */
class MembersController extends ApiBaseController
{
	public $modelClass = false;    //关闭model验证
    private $_memberSer;    //人员管理对象

    public function init()
    {
        parent::init();
        $this->_memberSer = new MemberService();
    }
    /**
     * 登录
     * @return string
     */
    public function actionOnLogin()
    {
        
        return $this->success();
    }

    /**
     * 默认页
     *
     */
    public function actionShow()
    {
    	return $this->error();
    }

    /** 
     * 管理人员列表
     * @param  $page  默认1   
     * @param  $limit  默认20
     */
    public function actionAdminList()
    {
        $page = \Yii::$app->request->post('page',1);
        $limit = \Yii::$app->request->post('limit',20);

        $count = $this->_memberSer->getAdminCount();
        $pageInfo = $this->getPageInfo($page, $limit, $count);
        $offset = ($pageInfo['page'] - 1) * $limit;
        $data = $pageInfo;
        // 列表
        $list = $this->_memberSer->getAdminPageList($limit, $offset);
        // 空返回
        if ($count < 1 || empty($list)) {
            $data['list'] = [];
            return $this->success($data);
        }
        $items = [];
        foreach ($list as $key => $value) {
            # data-list
            $item = [];
            $item['adId'] = $value->id;
            $item['adName'] = $value->name;
            $item['adPhone'] = $value->phone;
            $item['adPhoto'] = $value->photo;
            $item['adRole'] = $value->role;
            $item['adRoleId'] = $value->role_id;
            $item['adState'] = $value->state;
            $item['adStateName'] = $value->stateName[$value->state] ?: '异常';
            $item['lastLoginIp'] = $value->last_login_ip;
            $item['lastLoginAt'] = $value->last_login_time;
            $items[] = $item;
        }
        $data['list'] = $items;
        return $this->success($data);
    }

    /**
     * 管理人员详情
     * @param  $adId
     */
    public function actionAdminDetail()
    {
        $adId = \Yii::$app->request->post('adId',0);
        $info = $this->_memberSer->getAdminInfo($adId);
        if (empty($info)) {
            return $this->error('1010');
        }
        $item = [];
        $item['adId'] = $info->id;
        $item['adName'] = $info->name;
        $item['adPhone'] = $info->phone;
        $item['adPhoto'] = $info->photo;
        $item['adRole'] = $info->role;
        $item['adRoleId'] = $info->role_id;
        $item['adState'] = $info->state;
        $item['adStateName'] = $info->stateName[$info->state] ?: '异常';
        $item['lastLoginIp'] = $info->last_login_ip;
        $item['lastLoginAt'] = $info->last_login_time;
        return $this->success($item);
    }

    /**
     * 新增/编辑管理人员信息
     * @param  $adId  被修改管理人员ID
     * @param  $opId  操作人ID
     */
    public function actionAdminSet()
    {
        $adId = \Yii::$app->request->post('adId',0);
        $opId = \Yii::$app->request->post('opId');
        return  $this->error();
    }

    /**
     * 删除管理人员
     * @param  $adId  要删除管理人员ID
     * @param  $opId  操作人员ID
     */
    public function actionAdminDel()
    {
        $adId = \Yii::$app->request->post('adId');
        $opId = \Yii::$app->request->post('opId');
        return $this->error();
        // $res = $this->_memberSer->setAdminStateDel($adId, $opId);
    }

    /**
     * 管理人员操作log
     * @param  $adId  要查看点管理人员id
     */
    public function actionAdminLog()
    {
        $adId = \Yii::$app->request->post('adId');
        $page = \Yii::$app->request->post('page',1);
        $limit = \Yii::$app->request->post('limit',20);

        $count = $this->_memberSer->getAdminLogCount($adId);
        $pageInfo = $this->getPageInfo($page, $limit, $count);
        $offset = ($pageInfo['page'] - 1) * $limit;

        $list = $this->_memberSer->getAdminLogList($limit, $offset);
        // 空返回
        $data = $pageInfo;
        $items = [];
        foreach ($list as $key => $value) {
            # data-list
            $item = [];
            $item['logId'] = $value->id;
            $item['adId'] = $value->admin_id;
            $item['adName'] = $value->admins->name;
            $item['logType'] = $value->log_type;
            $item['content'] = $value->content;
            $item['createAt'] = $value->create_at;
            $items[] = $item;
        }
        $data['list'] = $items;
        return $this->success($data);
    }

    /**
     * 用户列表
     * @param  $userName  查询条件
     * @param  $phone  查询条件手机号
     * @param  $page
     * @param  $limit
     */
    public function actionUserList()
    {
        $userName = \Yii::$app->request->post('userName','');
        $phone = \Yii::$app->request->post('phone',0);
        $page = \Yii::$app->request->post('page','1');
        $limit = \Yii::$app->request->post('limit','20');

        $count = $this->_memberSer->getUsersCount($userName, $phone);
        $pageInfo = $this->getPageInfo($page, $limit, $count);
        $offset = ($pageInfo['page'] - 1) * $limit;

        $list = $this->_memberSer->getUsersList($userName,$phone);
    }

    /**
     * 用户详情
     *
     */
    public function actionUserDetail()
    {

    }

    /**
     * 新增/管理用户
     *
     */
    public function actionUserSet()
    {

    }

    /**
     * 用户删除
     *
     */
    public function actionUserDel()
    {

    }

    /**
     * 用户浏览记录
     *
     */
    public function actionUserHistory()
    {

    }

    /**
     * 用户收藏
     *
     */
    public function actionUserLike()
    {

    }

    /**
     * 作者列表
     *
     */
    public function actionAuthorList()
    {

    }

    /**
     * 作者详情
     *
     */
    public function actionAuthorDetail()
    {

    }

    /**
     * 新增/编辑作者
     *
     */
    public function actionAuthorSet()
    {

    }

    /**
     * 删除作者
     */
    public function actionAuthorDel()
    {

    }
}
