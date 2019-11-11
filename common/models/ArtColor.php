<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%art_color}}".
 *
 * @property int $id
 * @property int $art_id 图片ID
 * @property int $color_id 颜色ID
 * @property int $is_hot 热度排序
 * @property int $status 状态：1正常0删除
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%art_color}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['art_id', 'color_id', 'is_hot', 'status'], 'integer'],
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
            'art_id' => 'Art ID',
            'color_id' => 'Color ID',
            'is_hot' => 'Is Hot',
            'status' => 'Status',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
