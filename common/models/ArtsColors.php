<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%arts_colors}}".
 *
 * @property int $id
 * @property string $color_name 颜色名称
 * @property int $color_sort 排序，值越大越靠前
 * @property int $color_state 状态0删除1可用2禁用
 * @property string $color_desc 描述说明
 * @property string $color_code RGB编码
 * @property string $color_image 样式图片地址
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtsColors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arts_colors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_sort', 'color_state'], 'integer'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['color_name'], 'string', 'max' => 50],
            [['color_desc', 'color_image'], 'string', 'max' => 255],
            [['color_code'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color_name' => 'Color Name',
            'color_sort' => 'Color Sort',
            'color_state' => 'Color State',
            'color_desc' => 'Color Desc',
            'color_code' => 'Color Code',
            'color_image' => 'Color Image',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
