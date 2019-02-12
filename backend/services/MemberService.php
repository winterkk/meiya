<?php
namespace backend\services;

use common\services\CommonService;
use common\models\Admins;
use common\models\AdminsLog;

class MemberService extends CommonService
{
	/**
	 * 查询管理员总数
	 * @return  number
	 */
	public function getAdminCount()
	{
		return Admins::find()->where(['>','state',Admins::ADMIN_STATE_DEL])->count();
	}

	/**
	 * 管理员分页列表
	 * @param  $limit  步距
	 * @param  $offset  起始位置
	 */
	public function getAdminPageList($limit = 20,$offset = 0)
	{
		return Admins::find()->where(['>','state',Admins::ADMIN_STATE_DEL])->limit($limit)->offset($offset)->all();
	}

	/**
	 * 管理员详情
	 * @param  $id
	 */
	public function getAdminInfo($id)
	{
		return Admins::findOne($id);
	}

	/**
	 * 删除管理人员账号
	 * @param  $adId  管理员id
	 * @param  $opId  操作人员id
	 */
	public function setAdminStateDel($adId, $opId)
	{
		$adminInfo = $this->getAdminInfo($adId);
		try {
			if (empty($adminInfo)) {
				throw new Exception("管理员:".$adId."账号不存在！", 1);
			}
			$adminInfo->state = Admins::ADMIN_STATE_DEL;
			if (!$adminInfo->save()) {
				throw new Exception("删除管理人员:".$adId."失败！", 1);
			}
			// 记录操作记录
			
		} catch (Exception $e) {
			\Yii::error($e->getMessage());
			return false;
		}
	}

	/**
	 * 查询管理员操作日志
	 * @param  $adId  管理员id
	 */
	public function getAdminLogCount($adId)
	{
		return AdminsLog::find()->where(['admin_id'=>$adId])->count();
	}
}