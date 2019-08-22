<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%classes}}".
 *
 * @property int $id
 * @property string $name 类型名称
 * @property int $cover_img 类型封面
 * @property int $sort 排序权重
 * @property string $desc 类型说明
 * @property int $state 状态:1可用0删除
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Classes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%classes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cover_img', 'sort', 'state'], 'integer'],
            [['desc', 'create_at'], 'required'],
            [['desc'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['name'], 'string', 'max' => 150],
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
            'cover_img' => 'Cover Img',
            'sort' => 'Sort',
            'desc' => 'Desc',
            'state' => 'State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
