<?php

namespace common\models;

use Yii;
use common\models\ArtsStyles;

/**
 * This is the model class for table "{{%arts_contents}}".
 *
 * @property int $id 内容分类id
 * @property int $style_id 风格、品类id
 * @property string $content_name 内容分类名称
 * @property int $content_sort 排序，值越大越靠前
 * @property string $content_desc 内容分类描述
 * @property int $content_state 状态：0删除1可用2禁用
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtsContents extends \yii\db\ActiveRecord
{
    const CONTENT_STATE_USABLE = 1;
    const CONTENT_STATE_DISABLE = 2;
    const CONTENT_STATE_DEL = 0;

    public $contentStateNameBox = [
        0 => '删除',
        1 => '可用',
        2 => '禁用'
    ];
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
            [['style_id', 'content_sort', 'content_state'], 'integer'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['content_name'], 'string', 'max' => 50],
            [['content_desc'], 'string', 'max' => 255],
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
            'content_name' => 'Content Name',
            'content_sort' => 'Content Sort',
            'content_desc' => 'Content Desc',
            'content_state' => 'Content State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * 关联风格分类
     */
    public function getArtsStyles()
    {
        return $this->hasOne(ArtsStyles::className(),['id'=>'style_id']);
    }
}
