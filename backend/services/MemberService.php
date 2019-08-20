<?php
namespace backend\services;

/**
 * 人员管理类
 * @date  2019-02
 */
use common\services\CommonService;
use common\models\Admins;
use common\models\AdminsLog;
use common\models\Authors;
use common\models\Users;

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

	/**
	 * 获取作者信息
	 * @param  $authorId
	 * @return  object
	 */
	public function getAuthorInfoById($authorId)
	{
		return Authors::find()->where(['author_state'=>Authors::AUTHOR_STATE_USABLE])->one();
	}

	/**
	 * 用户数量统计
	 * @param  $userName  名字筛选
	 * @param  $phone  手机号筛选
	 * @return  number
	 */
	public function getUsersCount($userName='',$phone=0)
	{
		$count = Users::find()->where(['>','user_state',Users::USER_STATE_DEL]);
		if ($userName) {
			$count->andWhere(['user_name'=>$userName]);
		}
		if ($phone) {
			$count->andWhere(['user_phone'=>$phone]);
		}
		return $count->count();
	}

	/**
	 * 后台登录
	 * @param  $account 
	 * @param  $passwd
	 */
	public function checkAdminLogin($account,$passwd)
	{
		// 密码
		$checkPasswd = CommonService::hashPasswd($passwd);
		$adminInfo = Admins::find()
			->where(['name'=>$account,'password'=>$checkPasswd,'state'=>Admins::ADMIN_STATE_USABLE])
			->one();
		return $adminInfo;
	}
}