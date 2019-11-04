<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $nickname 昵称
 * @property string $cellphone 手机号
 * @property string $email 邮箱
 * @property string $realname 真实姓名
 * @property string $wechat_openid 微信openid
 * @property string $password 登录密码
 * @property string $avatar 头像
 * @property string $birth 出生日期
 * @property int $sex 性别:1男2女0保密
 * @property string $city 城市
 * @property string $province 省份
 * @property string $reg_ip 注册ip地址
 * @property string $reg_at 注册时间
 * @property string $last_login_ip 最后登陆ip地址
 * @property string $last_login_at 最后登录时间
 * @property string $questions 找回问题
 * @property string $answer 答案
 * @property int $status 状态:1正常0删除
 * @property int $is_set 是否授权
 * @property string $update_at 修改时间
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birth', 'reg_at', 'last_login_at', 'update_at'], 'safe'],
            [['sex', 'status', 'is_set'], 'integer'],
            [['reg_at', 'last_login_at', 'answer'], 'required'],
            [['answer'], 'string'],
            [['nickname', 'realname', 'wechat_openid'], 'string', 'max' => 50],
            [['cellphone', 'reg_ip', 'last_login_ip'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 32],
            [['avatar', 'city', 'province', 'questions'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'cellphone' => 'Cellphone',
            'email' => 'Email',
            'realname' => 'Realname',
            'wechat_openid' => 'Wechat Openid',
            'password' => 'Password',
            'avatar' => 'Avatar',
            'birth' => 'Birth',
            'sex' => 'Sex',
            'city' => 'City',
            'province' => 'Province',
            'reg_ip' => 'Reg Ip',
            'reg_at' => 'Reg At',
            'last_login_ip' => 'Last Login Ip',
            'last_login_at' => 'Last Login At',
            'questions' => 'Questions',
            'answer' => 'Answer',
            'status' => 'Status',
            'is_set' => 'Is Set',
            'update_at' => 'Update At',
        ];
    }
}
