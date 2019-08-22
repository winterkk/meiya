<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pics}}".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $pic_no 编号
 * @property int $sort 排序，值大在前
 * @property string $birth_at 创作时间
 * @property int $sku_num 数量
 * @property int $state 0删除1启用
 * @property string $unit_price 单价(每平米)
 * @property string $current_price 现价
 * @property string $pic_qrcode 二维码
 * @property int $thumb_img 缩略图
 * @property int $real_height 实际长度(mm)
 * @property int $real_width 实际宽度(mm)
 * @property string $mark 备注
 * @property string $desc 简介
 * @property int $class_id 分类
 * @property int $style_id 风格
 * @property int $cont_id 内容
 * @property int $views 浏览
 * @property int $likes 喜欢
 * @property int $dislikes 不喜欢
 * @property int $subscribe 收藏订阅
 * @property int $views_v 浏览偏移量
 * @property int $likes_v 喜欢偏移量
 * @property int $subscribe_v 收藏订阅偏移量
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Pics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pics}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort', 'sku_num', 'state', 'thumb_img', 'real_height', 'real_width', 'class_id', 'style_id', 'cont_id', 'views', 'likes', 'dislikes', 'subscribe', 'views_v', 'likes_v', 'subscribe_v'], 'integer'],
            [['birth_at', 'create_at', 'update_at'], 'safe'],
            [['unit_price', 'current_price'], 'number'],
            [['mark', 'create_at'], 'required'],
            [['mark', 'desc'], 'string'],
            [['title', 'pic_qrcode'], 'string', 'max' => 150],
            [['pic_no'], 'string', 'max' => 100],
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
            'pic_no' => 'Pic No',
            'sort' => 'Sort',
            'birth_at' => 'Birth At',
            'sku_num' => 'Sku Num',
            'state' => 'State',
            'unit_price' => 'Unit Price',
            'current_price' => 'Current Price',
            'pic_qrcode' => 'Pic Qrcode',
            'thumb_img' => 'Thumb Img',
            'real_height' => 'Real Height',
            'real_width' => 'Real Width',
            'mark' => 'Mark',
            'desc' => 'Desc',
            'class_id' => 'Class ID',
            'style_id' => 'Style ID',
            'cont_id' => 'Cont ID',
            'views' => 'Views',
            'likes' => 'Likes',
            'dislikes' => 'Dislikes',
            'subscribe' => 'Subscribe',
            'views_v' => 'Views V',
            'likes_v' => 'Likes V',
            'subscribe_v' => 'Subscribe V',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
