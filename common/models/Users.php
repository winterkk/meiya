<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $user_udid 编号
 * @property string $user_name 用户名
 * @property string $user_phone 手机号码
 * @property string $user_email 邮箱
 * @property string $user_realname 真实姓名
 * @property string $user_passwd 密码
 * @property string $user_photo 头像
 * @property string $user_birth 出生日期
 * @property int $user_sex 性别:1男2女3保密
 * @property int $user_state 状态:1正常0删除2冻结
 * @property string $token_key token验证key
 * @property string $wechat_openid 微信openid
 * @property int $city 城市id
 * @property int $is_new 1新用户0老用户
 * @property string $register_ip 注册ip地址
 * @property string $login_ip 最后登陆ip地址
 * @property int $level 用户等级
 * @property int $integral_total 总积分
 * @property int $integral 可用积分
 * @property int $integral_past 过期积分
 * @property string $questions 找回问题
 * @property string $answer 答案
 * @property int $login_nums 登陆次数
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Users extends \yii\db\ActiveRecord
{
    const USER_STATE_DEL = 0;
    const USER_STATE_USABLE = 1;
    const USER_STATE_LOCK = 2;

    public $userStateNameBox = [
        self::USER_STATE_DEL => '删除',
        self::USER_STATE_USABLE => '正常',
        self::USER_STATE_LOCK => '冻结'
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_birth', 'create_at', 'update_at'], 'safe'],
            [['user_sex', 'user_state', 'city', 'is_new', 'level', 'integral_total', 'integral', 'integral_past', 'login_nums'], 'integer'],
            [['create_at'], 'required'],
            [['user_udid'], 'string', 'max' => 11],
            [['user_name', 'user_email', 'user_realname', 'user_passwd'], 'string', 'max' => 32],
            [['user_phone', 'register_ip', 'login_ip'], 'string', 'max' => 15],
            [['user_photo'], 'string', 'max' => 255],
            [['token_key', 'wechat_openid'], 'string', 'max' => 50],
            [['questions', 'answer'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_udid' => 'User Udid',
            'user_name' => 'User Name',
            'user_phone' => 'User Phone',
            'user_email' => 'User Email',
            'user_realname' => 'User Realname',
            'user_passwd' => 'User Passwd',
            'user_photo' => 'User Photo',
            'user_birth' => 'User Birth',
            'user_sex' => 'User Sex',
            'user_state' => 'User State',
            'token_key' => 'Token Key',
            'wechat_openid' => 'Wechat Openid',
            'city' => 'City',
            'is_new' => 'Is New',
            'register_ip' => 'Register Ip',
            'login_ip' => 'Login Ip',
            'level' => 'Level',
            'integral_total' => 'Integral Total',
            'integral' => 'Integral',
            'integral_past' => 'Integral Past',
            'questions' => 'Questions',
            'answer' => 'Answer',
            'login_nums' => 'Login Nums',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
