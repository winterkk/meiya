<?php

namespace common\models;

use Yii;
use common\models\ArtsStyles;

/**
 * This is the model class for table "{{%arts_classes}}".
 *
 * @property int $id
 * @property string $class_name 类型名称
 * @property int $class_sort 类型显示排序
 * @property string $class_desc 类型说明
 * @property int $class_state 状态:1可用2禁用0删除
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class ArtsClasses extends \yii\db\ActiveRecord
{
    const CLASS_STATE_DISABLE = 2;
    const CLASS_STATE_USABLE = 1;
    const CLASS_STATE_DEL = 0;

    public $classStateNameBox = [
        0 => '删除',
        1 => '可用',
        2 => '禁用'
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%arts_classes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_sort', 'class_state'], 'integer'],
            [['create_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['class_name'], 'string', 'max' => 100],
            [['class_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_name' => 'Class Name',
            'class_sort' => 'Class Sort',
            'class_desc' => 'Class Desc',
            'class_state' => 'Class State',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * 关联风格分类
     */
    public function getArtsStyles()
    {
        return $this->hasMany(ArtsStyles::className(),['class_id'=>'id']);
    }

    /**
     * 分类集合缓存数据
     * @return 
     */
    public static function getArtClassesSet()
    {
        $cache = \Yii::$app->cache;
        $key = 'ART_CLASS_SET';
        $list = $cache->get($key);
        if ($list === false) {
            $list = self::find()->where(['>','class_state',self::CLASS_STATE_DEL])->orderBy('class_sort')->all();
            if (!empty($list)) {
                $cache->set($key,$list,3600);
            }
        }
        return $list;
    }

    /**
     * 查询分类详情
     * @param  $param  分类id或者分类名
     * @return  object
     */
    public static function getArtClassInfo($param)
    {
        $list = $this->getArtClassesSet();
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                if ($value->id == $param || $value->class_name == $param) {
                    return $value;
                }
            }
        }
        return [];
    }
}
