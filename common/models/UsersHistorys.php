<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%users_historys}}".
 *
 * @property int $id
 * @property int $user_id 用户
 * @property int $art_id 画作
 * @property string $querystring 请求字符串
 * @property int $state 状态1可用0删除2不显示
 * @property string $create_at 创建时间
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
            [['user_id', 'art_id', 'state'], 'integer'],
            [['create_at'], 'required'],
            [['create_at'], 'safe'],
            [['querystring'], 'string', 'max' => 255],
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
            'querystring' => 'Querystring',
            'state' => 'State',
            'create_at' => 'Create At',
        ];
    }
}
