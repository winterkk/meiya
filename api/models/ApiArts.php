<?php
namespace api\models;

use Yii;
use yii\db\Exception;
use common\models\Arts;
use common\services\CommonService;

/**
 * 图片数据处理
 */
class ApiArts extends Arts
{
	// 常量定义
	const ART_DELETE = 0;
	const ART_USEFUL = 1;

	/**
	 * 条件查询图片数量
	 * @param  $class  类型
	 * @param  $style  风格
	 * @param  $content  内容
	 * @param  $color  颜色
	 */
	public function getArtCount($class=[],$style=[],$content=[],$color=[])
	{
		
	}
}