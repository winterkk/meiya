<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%arts_images}}".
 *
 * @property int $id
 * @property string $img_path 图片地址
 * @property int $is_master 是否主图
 * @property int $art_id 图片ID
 * @property int $img_sort 显示排序
 * @property int $img_state 状态:1可用0删除
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtsImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arts_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_master', 'art_id', 'img_sort', 'img_state'], 'integer'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['img_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img_path' => 'Img Path',
            'is_master' => 'Is Master',
            'art_id' => 'Art ID',
            'img_sort' => 'Img Sort',
            'img_state' => 'Img State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
