<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%arts}}".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $art_no 编号
 * @property int $sort 排序，值大在前
 * @property string $birth 创作时间
 * @property int $sku_num 数量
 * @property string $unit_price 单价(每平米)
 * @property string $current_price 现价
 * @property string $qrcode 二维码
 * @property int $cover_img 缩略图
 * @property int $real_height 实际长度(mm)
 * @property int $real_width 实际宽度(mm)
 * @property int $class_id 分类
 * @property int $style_id 风格
 * @property int $cont_id 内容
 * @property int $state 0删除1启用
 * @property string $desc 简介
 * @property string $mark 备注
 * @property int $views 浏览
 * @property int $likes 喜欢
 * @property int $subscribe 收藏订阅
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Arts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort', 'sku_num', 'cover_img', 'real_height', 'real_width', 'class_id', 'style_id', 'cont_id', 'state', 'views', 'likes', 'subscribe'], 'integer'],
            [['birth', 'create_at', 'update_at'], 'safe'],
            [['unit_price', 'current_price'], 'number'],
            [['desc', 'mark'], 'string'],
            [['mark', 'create_at'], 'required'],
            [['title', 'qrcode'], 'string', 'max' => 150],
            [['art_no'], 'string', 'max' => 100],
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
            'art_no' => 'Art No',
            'sort' => 'Sort',
            'birth' => 'Birth',
            'sku_num' => 'Sku Num',
            'unit_price' => 'Unit Price',
            'current_price' => 'Current Price',
            'qrcode' => 'Qrcode',
            'cover_img' => 'Cover Img',
            'real_height' => 'Real Height',
            'real_width' => 'Real Width',
            'class_id' => 'Class ID',
            'style_id' => 'Style ID',
            'cont_id' => 'Cont ID',
            'state' => 'State',
            'desc' => 'Desc',
            'mark' => 'Mark',
            'views' => 'Views',
            'likes' => 'Likes',
            'subscribe' => 'Subscribe',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
