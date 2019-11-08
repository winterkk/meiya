<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property int $id
 * @property string $username 用户
 * @property string $password 密码
 * @property string $salt 干扰码
 * @property string $phone 手机
 * @property string $email 邮箱
 * @property string $avatar 头像
 * @property string $reg_at
 * @property string $reg_ip 注册IP
 * @property int $status 0删除1正常2禁用
 * @property string $login_at
 * @property string $login_ip
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'login_at'], 'required'],
            [['avatar'], 'string'],
            [['reg_at', 'login_at', 'login_ip'], 'safe'],
            [['status'], 'integer'],
            [['username', 'password', 'email'], 'string', 'max' => 64],
            [['salt'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 15],
            [['reg_ip'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => 'Password',
            'salt' => 'Salt',
            'phone' => '手机号',
            'email' => 'Email',
            'avatar' => 'Avatar',
            'reg_at' => 'Reg At',
            'reg_ip' => 'Reg Ip',
            'status' => 'Status',
            'login_at' => 'Login At',
            'login_ip' => 'Login Ip',
        ];
    }
}
