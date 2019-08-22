<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%styles}}".
 *
 * @property int $id
 * @property int $class_id 类型分类id
 * @property int $cover_img 类型封面
 * @property string $name 风格分类名
 * @property int $sort 排序权重
 * @property int $state 状态0删除1可用
 * @property string $desc 风格、品类描述
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Styles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%styles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'cover_img', 'sort', 'state'], 'integer'],
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
            'class_id' => 'Class ID',
            'cover_img' => 'Cover Img',
            'name' => 'Name',
            'sort' => 'Sort',
            'state' => 'State',
            'desc' => 'Desc',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
