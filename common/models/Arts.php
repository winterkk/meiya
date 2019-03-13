<?php

namespace common\models;

use Yii;
use common\models\ArtsClasses;
use common\models\ArtsStyles;
use common\models\ArtsContents;
use common\models\ArtsColors;
use common\models\ArtsImages;

/**
 * This is the model class for table "{{%arts}}".
 *
 * @property int $id
 * @property string $art_title 名称
 * @property string $art_no 编号
 * @property int $art_sort 排序,值越大越靠前
 * @property int $author_id 作家id
 * @property string $birth_at 创作时间
 * @property int $art_num 数量
 * @property int $art_state 0删除1启用2禁用
 * @property string $market_price 市场价
 * @property string $current_price 现价
 * @property string $qrcode 二维码
 * @property string $show_image 展示缩略图
 * @property int $art_class 类型分类
 * @property int $art_style 风格分类
 * @property int $art_content 内容分类
 * @property int $art_color 颜色
 * @property int $art_length 长度(cm)
 * @property int $art_width 宽度(cm)
 * @property string $art_size 图片存储大小
 * @property int $art_dpi 图片分辨率
 * @property string $mark 备注
 * @property string $desc 简介
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
class Arts extends \yii\db\ActiveRecord
{
    const ART_STATE_USABLE = 1;
    const ART_STATE_DISABLE = 2;
    const ART_STATE_DEL = 0;

    public $artStateNameBox = [
        self::ART_STATE_USABLE => '启用',
        self::ART_STATE_DISABLE => '禁用',
        self::ART_STATE_DEL => '删除'
    ];
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
            [['art_sort', 'author_id', 'art_num', 'art_state', 'art_class', 'art_style', 'art_content', 'art_color', 'art_length', 'art_width', 'art_dpi', 'views', 'likes', 'dislikes', 'subscribe', 'views_v', 'likes_v', 'subscribe_v'], 'integer'],
            [['birth_at', 'create_at', 'update_at'], 'safe'],
            [['market_price', 'current_price', 'art_size'], 'number'],
            [['desc'], 'string'],
            [['create_at'], 'required'],
            [['art_title'], 'string', 'max' => 150],
            [['art_no'], 'string', 'max' => 20],
            [['qrcode'], 'string', 'max' => 30],
            [['show_image', 'mark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'art_title' => 'Art Title',
            'art_no' => 'Art No',
            'art_sort' => 'Art Sort',
            'author_id' => 'Author ID',
            'birth_at' => 'Birth At',
            'art_num' => 'Art Num',
            'art_state' => 'Art State',
            'market_price' => 'Market Price',
            'current_price' => 'Current Price',
            'qrcode' => 'Qrcode',
            'show_image' => 'Show Image',
            'art_class' => 'Art Class',
            'art_style' => 'Art Style',
            'art_content' => 'Art Content',
            'art_color' => 'Art Color',
            'art_length' => 'Art Length',
            'art_width' => 'Art Width',
            'art_size' => 'Art Size',
            'art_dpi' => 'Art Dpi',
            'mark' => 'Mark',
            'desc' => 'Desc',
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

    // 关联表
    // 关联类型分类
    public function getArtsClasses()
    {
        return $this->hasOne(ArtsClasses::className(),['id'=>'art_class']);
    }

    // 关联风格分类
    public function getArtsStyles()
    {
        return $this->hasOne(ArtsStyles::className(),['id'=>'art_style']);
    }

    // 关联内容分类
    public function getArtsContents()
    {
        return $this->hasOne(ArtsContents::className(),['id'=>'art_content']);
    }

    // 关联颜色表
    public function getArtsColors()
    {
        return $this->hasOne(ArtsColors::className(),['id'=>'art_color']);
    }

    // 关联图片表
    public function getArtsImages()
    {
        return $this->hasMany(ArtsImages::className(),['art_id'=>'id']);
    }
}
