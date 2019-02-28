<?php

namespace common\models;

use Yii;
use common\models\ArtsClasses;
use common\models\ArtsContents;

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
    const STYLE_STATE_USABLE = 1;
    const STYLE_STATE_DISABLE = 2;
    const STYLE_STATE_DEL = 0;

    public $styleStateNameBox = [
        1 => '可用',
        2 => '禁用',
        0 => '删除'
    ];
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

    /**
     * 关联类型表
     */
    public function getArtsClasses()
    {
        return $this->hasOne(ArtsClasses::className(),['id'=>'class_id']);
    }

    /**
     * 关联内容分类表
     */
    public function getArtsContents()
    {
        return $this->hasMany(ArtsContents::className(),['style_id'=>'id']);
    }
}
