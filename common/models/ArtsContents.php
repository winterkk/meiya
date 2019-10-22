<?php

namespace common\models;

use Yii;
use common\models\Imgs;
use common\models\ArtsStyles;

/**
 * This is the model class for table "{{%arts_contents}}".
 *
 * @property int $id 内容分类id
 * @property int $style_id 风格、品类id
 * @property string $title 内容分类名称
 * @property int $cover_img 内容封面
 * @property int $sort 排序权重
 * @property string $desc 内容分类描述
 * @property int $state 状态：0删除1可用
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtsContents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arts_contents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['style_id', 'cover_img', 'sort', 'state'], 'integer'],
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
            'style_id' => 'Style ID',
            'title' => 'Title',
            'cover_img' => 'Cover Img',
            'sort' => 'Sort',
            'desc' => 'Desc',
            'state' => 'State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * 封面
     */
    public function getContentImg()
    {
        return $this->hasOne(Imgs::className(),['id'=>'cover_img']);
    }

    /**
     * 内容关联样式
     */
    public function getArtsStyles()
    {
        return $this->hasOne(ArtsStyles::className(),['id'=>'style_id']);
    }
}
