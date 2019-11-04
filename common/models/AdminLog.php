<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admin_log}}".
 *
 * @property int $id
 * @property int $ad_id 操作人
 * @property string $title 标题
 * @property string $controller 控制器
 * @property string $action 方法名
 * @property string $querystring 查询字符串
 * @property string $remark 备注
 * @property string $ip ip地址
 * @property int $status 状态:1显示0隐藏
 * @property string $create_at 创建时间
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ad_id', 'status'], 'integer'],
            [['querystring', 'create_at'], 'required'],
            [['querystring', 'remark'], 'string'],
            [['create_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['controller', 'action'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ad_id' => 'Ad ID',
            'title' => 'Title',
            'controller' => 'Controller',
            'action' => 'Action',
            'querystring' => 'Querystring',
            'remark' => 'Remark',
            'ip' => 'Ip',
            'status' => 'Status',
            'create_at' => 'Create At',
        ];
    }
}
