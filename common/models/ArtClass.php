<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%art_class}}".
 *
 * @property int $id
 * @property string $title 类型名称
 * @property int $cover_img 类型封面
 * @property int $sort 排序权重
 * @property string $desc 类型说明
 * @property int $status 状态:1可用0删除
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%art_class}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cover_img', 'sort', 'status'], 'integer'],
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
            'title' => 'Title',
            'cover_img' => 'Cover Img',
            'sort' => 'Sort',
            'desc' => 'Desc',
            'status' => 'Status',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
