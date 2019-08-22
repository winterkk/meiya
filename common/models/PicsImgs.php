<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pics_imgs}}".
 *
 * @property int $id
 * @property int $pic_id 图片编号
 * @property int $img_id 图片地址
 * @property int $state 状态：1正常0删除
 * @property int $type 类型：1原图2大图3中图4小图
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class PicsImgs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pics_imgs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pic_id', 'img_id', 'state', 'type'], 'integer'],
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
            'pic_id' => 'Pic ID',
            'img_id' => 'Img ID',
            'state' => 'State',
            'type' => 'Type',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
