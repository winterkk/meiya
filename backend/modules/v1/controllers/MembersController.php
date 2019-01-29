<?php
namespace backend\modules\v1\controllers;

use backend\controllers\ApiBaseController;
use yii;

/**
 * 人员管理类
 * 
 */
class MembersController extends ApiBaseController
{
	public $modelClass = false;

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
     * 
     */
    public function actionAdminList()
    {

    }

    /**
     * 管理人员详情
     * @param  $id
     */
    public function actionAdminDetail()
    {

    }

    /**
     * 新增/编辑管理人员信息
     * @param  $id
     * @param  $operatorId
     */
    public function actionAdminSet()
    {

    }

    /**
     * 删除管理人员
     */
    public function actionAdminDel()
    {

    }

    /**
     * 管理人员操作log
     *
     */
    public function actionAdminLog()
    {

    }

    /**
     * 用户列表
     *
     */
    public function actionUserList()
    {

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
