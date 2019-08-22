<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%users_historys}}".
 *
 * @property int $id
 * @property int $user_id 用户
 * @property int $pic_id 画作
 * @property string $history_value 内容
 * @property int $state 状态1可用0删除2不显示
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class UsersHistorys extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users_historys}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'pic_id', 'state'], 'integer'],
            [['history_value'], 'string'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'pic_id' => 'Pic ID',
            'history_value' => 'History Value',
            'state' => 'State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
