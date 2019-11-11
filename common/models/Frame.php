<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%frame}}".
 *
 * @property int $id
 * @property string $title 名称
 * @property string $frame_no 编号
 * @property string $unit_price 单价(m)
 * @property int $frame_image 框样图
 * @property int $status 状态:1正常0删除
 * @property int $sort 排序
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Frame extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%frame}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_price'], 'number'],
            [['frame_image', 'status', 'sort'], 'integer'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['frame_no'], 'string', 'max' => 100],
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
            'frame_no' => 'Frame No',
            'unit_price' => 'Unit Price',
            'frame_image' => 'Frame Image',
            'status' => 'Status',
            'sort' => 'Sort',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
