<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%imgs}}".
 *
 * @property int $id
 * @property string $path 图片地址
 * @property int $width 图片宽度
 * @property int $height 图片高度
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Imgs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%imgs}}';
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
            'path' => 'Path',
            'width' => 'Width',
            'height' => 'Height',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
