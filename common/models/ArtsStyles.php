<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%arts_styles}}".
 *
 * @property int $id
 * @property int $class_id 类型分类id
 * @property string $style_name 风格分类名
 * @property int $style_sort 显示排序，值越大越靠前
 * @property int $style_state 状态0删除1可用2禁用
 * @property string $style_desc 风格、品类描述
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtsStyles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arts_styles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'style_sort', 'style_state'], 'integer'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['style_name'], 'string', 'max' => 50],
            [['style_desc'], 'string', 'max' => 255],
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
            'style_name' => 'Style Name',
            'style_sort' => 'Style Sort',
            'style_state' => 'Style State',
            'style_desc' => 'Style Desc',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
