<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%art_style}}".
 *
 * @property int $id
 * @property int $class_id 类型分类id
 * @property string $title 风格分类名
 * @property int $cover_img 类型封面
 * @property int $sort 排序权重
 * @property int $status 状态0删除1可用
 * @property string $desc 风格、品类描述
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtStyle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%art_style}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'cover_img', 'sort', 'status'], 'integer'],
            [['desc'], 'string'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['title'], 'string', 'max' => 150],
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
            'title' => 'Title',
            'cover_img' => 'Cover Img',
            'sort' => 'Sort',
            'status' => 'Status',
            'desc' => 'Desc',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
