<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%users_likes}}".
 *
 * @property int $id
 * @property int $user_id 用户
 * @property int $pic_id 画作
 * @property int $like_state 0删除1可用
 * @property string $create_at 添加时间
 * @property string $update_at 修改时间
 */
class UsersLikes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users_likes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'pic_id', 'like_state'], 'integer'],
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
            'like_state' => 'Like State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
