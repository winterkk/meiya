<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%author}}".
 *
 * @property int $id
 * @property string $nickname 昵称
 * @property string $realname 姓名
 * @property string $phone 手机号
 * @property string $avatar 头像
 * @property int $sex 性别1男2女0保密
 * @property string $birthday 出生日期
 * @property int $prov_id 省
 * @property int $city_id 市
 * @property int $area_id 区县
 * @property string $addr 详细地址
 * @property string $desc 简介
 * @property string $mark 备注
 * @property int $status 状态：1可用0删除
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%author}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex', 'prov_id', 'city_id', 'area_id', 'status'], 'integer'],
            [['birthday', 'create_at', 'update_at'], 'safe'],
            [['desc'], 'string'],
            [['create_at'], 'required'],
            [['nickname', 'realname'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['avatar', 'addr', 'mark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'realname' => 'Realname',
            'phone' => 'Phone',
            'avatar' => 'Avatar',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'prov_id' => 'Prov ID',
            'city_id' => 'City ID',
            'area_id' => 'Area ID',
            'addr' => 'Addr',
            'desc' => 'Desc',
            'mark' => 'Mark',
            'status' => 'Status',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
