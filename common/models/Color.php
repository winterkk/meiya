<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%color}}".
 *
 * @property int $id
 * @property string $title 颜色名称
 * @property int $cover_img 样式图片
 * @property string $code RGB编码
 * @property int $sort 排序权重
 * @property int $status 状态0删除1可用
 * @property string $desc 描述说明
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Color extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%color}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cover_img', 'sort', 'status'], 'integer'],
            [['desc'], 'string'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['title'], 'string', 'max' => 150],
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
            'title' => 'Title',
            'cover_img' => 'Cover Img',
            'code' => 'Code',
            'sort' => 'Sort',
            'status' => 'Status',
            'desc' => 'Desc',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
