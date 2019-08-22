<?php
namespace common\services;

use Yii;
use yii\web\UploadedFile;

/**
 * 文件上传处理
 * @date  2019-08
 */

class UploadService
{
	/**
	 * 单文件上传
	 *
	 */
	public function singleUpload()
	{
		$upload = \Yii::$app->params['uploadPath'];
        $img = UploadedFile::getInstanceByName('image');
        $filename = $upload .'/'. date('Y').'/'.date('m');
        if (!is_dir($filename)) {
            @mkdir($filename, 0777, true);
        }
        $filename .= '/'.$img->name;
        $img->saveAs($filename);
	}

	/**
	 * 多文件上传
	 *
	 */
	public function moreUpload()
	{

	}
}