<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%options}}".
 *
 * @property int $id
 * @property int $admin_id 操作人
 * @property string $name 标题
 * @property string $content 内容
 * @property string $create_at 时间
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%options}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_id'], 'integer'],
            [['content'], 'string'],
            [['create_at'], 'required'],
            [['create_at'], 'safe'],
            [['name'], 'string', 'max' => 200],
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
            'name' => 'Name',
            'content' => 'Content',
            'create_at' => 'Create At',
        ];
    }
}
