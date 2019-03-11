<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admins_logs}}".
 *
 * @property int $id
 * @property int $admin_id 管理员id
 * @property int $log_type 日志类型:1登录2登出3增加4修改5删除
 * @property string $content 日志内容
 * @property string $create_at 日志生成时间
 */
class AdminsLogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admins_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_id', 'log_type'], 'integer'],
            [['content'], 'string'],
            [['create_at'], 'required'],
            [['create_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'Admin ID',
            'log_type' => 'Log Type',
            'content' => 'Content',
            'create_at' => 'Create At',
        ];
    }
}
