<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property int $id
 * @property string $path 图片地址
 * @property string $md5 md5校验
 * @property int $width 图片宽度
 * @property int $height 图片高度
 * @property string $create_at 创建时间
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'create_at'], 'required'],
            [['path'], 'string'],
            [['width', 'height'], 'integer'],
            [['create_at'], 'safe'],
            [['md5'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'md5' => 'Md5',
            'width' => 'Width',
            'height' => 'Height',
            'create_at' => 'Create At',
        ];
    }
}
