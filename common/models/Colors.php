<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%colors}}".
 *
 * @property int $id
 * @property string $name 颜色名称
 * @property int $sort 排序权重
 * @property int $state 状态0删除1可用
 * @property string $desc 描述说明
 * @property string $code RGB编码
 * @property int $color_img 样式图片
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Colors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%colors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort', 'state', 'color_img'], 'integer'],
            [['desc', 'create_at'], 'required'],
            [['desc'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['code'], 'string', 'max' => 20],
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
            'sort' => 'Sort',
            'state' => 'State',
            'desc' => 'Desc',
            'code' => 'Code',
            'color_img' => 'Color Img',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
