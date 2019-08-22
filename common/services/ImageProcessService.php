<?php
namespace common\services;

use Yii;
use yii\imagine\Image;

/**
 * 图片常用处理
 * 扩展yii/yii2-imagine
 * @date 2019-08
 */

class ImageProcessService
{
	/**
	 * 缩略
	 * @param  $srcImg  源图
	 * @param  $saveImg  保存图片
	 * @param  $width  宽度，null表示自适应
	 * @param  $height  高度，null表示自适应
	 * @param  $type  inset定框缩略，outbound单尺寸优先缩略并居中截取
	 * 备注：定框的宽度或高度必须有一个小于图片的实际尺寸，否则直接返回源图尺寸
	 * 备注：outbound参数为函数的默认值，它会为您尽可能多的截取图片但又不会超出图片范围
	 * 例：源图 500x200，那么按照高度 100 缩略（变为250x100），然后再居中截取 200x100
	 */
	public static function imgThumb($srcImg,$saveImg,$width=null,$height=null,$type='')
	{
		switch ($type) {
			case 'inset':
				# 定框缩略
				Image::thumbnail($srcImg, $width, $height, 'inset')->save($saveImg,['quality'=>100]);
				break;
			case 'outbound':
				# 单尺寸优先缩略并居中截取
				Image::thumbnail($srcImg, $width, $height, 'outbound')->save($saveImg,['quality'=>100]);
				break;
			default:
				# 缩略
				Image::thumbnail($srcImg, $width, $height)->save($saveImg,['quality'=>100]);
				break;
		}
		return true;
	}

	/**
	 * 剪切
	 * @param  $srcImg  源图
	 * @param  $saveImg  保存图片
	 * @param  $width  保存宽度
	 * @param  $height  保存高度
	 * @param  $x  裁剪起始x轴
	 * @param  $y  裁剪起始y轴
	 */
	public static function imgCrop($srcImg, $saveImg, $width, $height, $x=0, $y=0)
	{
		return Image::crop($srcImg, $width, $height, [$x,$y])->save($saveImg);
	}

	/**
	 * 旋转
	 * @param  $srcImg
	 * @param  $saveImg
	 */
	public static function imgFrame($srcImg, $saveImg)
	{
		return Image::frame($srcImg)->rotate(90)->save($saveImg,['quality'=>100]);
	}

	/**
	 * 图片水印
	 * @param  $srcImg  原图
	 * @param  $saveImg  保存图片
	 * @param  $watermarkImg  水印图片
	 * @param  $x  水印位置
	 * @param  $y  水印位置
	 */
	public static function imgWatermarkPic($srcImg, $saveImg, $watermarkImg, $x=100, $y=100)
	{
		return Image::watermark($srcImg, $watermarkImg, [$x, $y])->save($saveImg,['quality'=>100]);
	}

	/**
	 * 文字水印
	 * @param  $srcImg  原图
	 * @param  $saveImg  保存图片
	 * @param  $str  水印文字
	 * @param  $x  水印位置
	 * @param  $y  水印位置
	 */
	public static function imgWatermarkText($srcImg, $saveImg, $str, $x=100, $y=100)
	{
		$font = Yii::getAlias('@common/fonts/shoujintijian.ttf');
		$color = '8a8c8e';
		$size = '38';
		$angle = '30';
		return Image::text($srcImg,$str,$font,[$x,$y],['color'=>$color,'size'=>$size,'angle'=>$angle])->save($saveImg,['quality'=>'100']);
	}
}