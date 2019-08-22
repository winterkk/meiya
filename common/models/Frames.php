<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%frames}}".
 *
 * @property int $id
 * @property string $title 名称
 * @property string $f_no 编号
 * @property string $unit_price 单价(m)
 * @property int $f_img 框样图
 * @property int $state 状态:1正常0删除
 * @property int $sort 排序
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Frames extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%frames}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_price'], 'number'],
            [['f_img', 'state', 'sort'], 'integer'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['f_no'], 'string', 'max' => 100],
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
            'f_no' => 'F No',
            'unit_price' => 'Unit Price',
            'f_img' => 'F Img',
            'state' => 'State',
            'sort' => 'Sort',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
