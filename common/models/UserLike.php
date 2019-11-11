<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_like}}".
 *
 * @property int $id
 * @property int $user_id 用户
 * @property int $art_id 画作
 * @property int $status 0删除1可用
 * @property string $create_at 添加时间
 * @property string $update_at 修改时间
 */
class UserLike extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_like}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'art_id', 'status'], 'integer'],
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
            'art_id' => 'Art ID',
            'status' => 'Status',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
