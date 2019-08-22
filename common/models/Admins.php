<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admins}}".
 *
 * @property int $id
 * @property string $name 账户
 * @property string $phone 手机号
 * @property string $password 密码
 * @property string $photo 头像地址
 * @property string $email 邮箱地址
 * @property string $role 角色
 * @property int $role_id 角色id
 * @property int $state 状态0删除1有效2禁用
 * @property string $last_login_time 最后登录时间
 * @property string $last_login_ip 最后登录ip地址
 * @property string $create_at 注册时间
 * @property string $update_at 修改时间
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
            [['role_id', 'state'], 'integer'],
            [['last_login_time', 'create_at'], 'required'],
            [['last_login_time', 'create_at', 'update_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['password'], 'string', 'max' => 64],
            [['photo'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 100],
            [['last_login_ip'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'password' => 'Password',
            'photo' => 'Photo',
            'email' => 'Email',
            'role' => 'Role',
            'role_id' => 'Role ID',
            'state' => 'State',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
