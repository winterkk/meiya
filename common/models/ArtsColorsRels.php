<?php

namespace common\models;

use Yii;
use common\models\ArtsColors;

/**
 * This is the model class for table "{{%arts_colors_rels}}".
 *
 * @property int $id
 * @property int $art_id 图片ID
 * @property int $color_id 颜色ID
 * @property int $is_hot 热度排序
 * @property int $state 状态：1正常0删除
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtsColorsRels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arts_colors_rels}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['art_id', 'color_id', 'is_hot', 'state'], 'integer'],
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
            'state' => 'State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     *
     */
    public function getArtsColors()
    {
         return $this->hasOne(ArtsColors::className(),['id'=>'color_id']);
    }
}
