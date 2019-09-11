<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admins_logs}}".
 *
 * @property int $id
 * @property int $aid 操作人
 * @property string $title 标题
 * @property string $controller 控制器
 * @property string $action 方法名
 * @property string $querystring 查询字符串
 * @property string $remark 备注
 * @property string $ip ip地址
 * @property int $state 状态:1显示0隐藏
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
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
            [['aid', 'state'], 'integer'],
            [['remark'], 'string'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['controller', 'action'], 'string', 'max' => 50],
            [['querystring'], 'string', 'max' => 255],
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
            'aid' => 'Aid',
            'title' => 'Title',
            'controller' => 'Controller',
            'action' => 'Action',
            'querystring' => 'Querystring',
            'remark' => 'Remark',
            'ip' => 'Ip',
            'state' => 'State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
