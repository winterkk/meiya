<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admins}}".
 *
 * @property int $id
 * @property string $username 账户
 * @property string $password 密码
 * @property string $salt 密码干扰字
 * @property string $cellphone 手机号
 * @property string $email 邮箱地址
 * @property string $avatar 头像地址
 * @property string $reg_at 注册时间
 * @property string $reg_ip 注册ip
 * @property int $state 状态0删除1有效2禁用
 * @property string $last_login_at 最后登录时间
 * @property string $last_login_ip 最后登录ip地址
 */
class Admins extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admins}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_at', 'last_login_at'], 'required'],
            [['reg_at', 'last_login_at'], 'safe'],
            [['state'], 'integer'],
            [['username', 'email'], 'string', 'max' => 50],
            [['password', 'salt'], 'string', 'max' => 32],
            [['cellphone'], 'string', 'max' => 15],
            [['avatar'], 'string', 'max' => 255],
            [['reg_ip', 'last_login_ip'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'salt' => 'Salt',
            'cellphone' => 'Cellphone',
            'email' => 'Email',
            'avatar' => 'Avatar',
            'reg_at' => 'Reg At',
            'reg_ip' => 'Reg Ip',
            'state' => 'State',
            'last_login_at' => 'Last Login At',
            'last_login_ip' => 'Last Login Ip',
        ];
    }
}
