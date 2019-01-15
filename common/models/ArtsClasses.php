<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%arts_classes}}".
 *
 * @property int $id
 * @property string $class_name 类型名称
 * @property int $class_sort 类型显示排序
 * @property string $class_desc 类型说明
 * @property int $class_state 状态:1可用0禁用2删除
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtsClasses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arts_classes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_sort', 'class_state'], 'integer'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['class_name'], 'string', 'max' => 100],
            [['class_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_name' => 'Class Name',
            'class_sort' => 'Class Sort',
            'class_desc' => 'Class Desc',
            'class_state' => 'Class State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
