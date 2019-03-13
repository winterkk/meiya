<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%authors}}".
 *
 * @property int $id
 * @property string $author_no 唯一编号
 * @property string $author_name 姓名
 * @property string $author_phone 手机号
 * @property int $author_sex 性别1男2女3保密
 * @property string $birthday 出生日期
 * @property int $province_id 省份
 * @property int $city_id 城市
 * @property int $area_id 区县
 * @property string $addr_info 所在地区
 * @property string $author_photo 照片
 * @property string $desc 简介
 * @property string $mark 备注
 * @property int $author_state 状态：1可用0删除
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Authors extends \yii\db\ActiveRecord
{
    const AUTHOR_STATE_USABLE = 1;
    const AUTHOR_STATE_DISABLE = 2;
    const AUTHOR_STATE_DEL = 0;

    public $authorStateNameBox = [
        AUTHOR_STATE_DEL => '删除',
        AUTHOR_STATE_USABLE => '可用',
        AUTHOR_STATE_DISABLE => '禁用'
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%authors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_sex', 'province_id', 'city_id', 'area_id', 'author_state'], 'integer'],
            [['birthday', 'create_at'], 'required'],
            [['birthday', 'create_at', 'update_at'], 'safe'],
            [['desc'], 'string'],
            [['author_no'], 'string', 'max' => 20],
            [['author_name'], 'string', 'max' => 50],
            [['author_phone'], 'string', 'max' => 15],
            [['addr_info'], 'string', 'max' => 255],
            [['author_photo', 'mark'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_no' => 'Author No',
            'author_name' => 'Author Name',
            'author_phone' => 'Author Phone',
            'author_sex' => 'Author Sex',
            'birthday' => 'Birthday',
            'province_id' => 'Province ID',
            'city_id' => 'City ID',
            'area_id' => 'Area ID',
            'addr_info' => 'Addr Info',
            'author_photo' => 'Author Photo',
            'desc' => 'Desc',
            'mark' => 'Mark',
            'author_state' => 'Author State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
