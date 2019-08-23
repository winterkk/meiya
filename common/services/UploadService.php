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
	 * @param  $fileName
	 */
	public function singleUpload($fileName)
	{
		try {
			$upload = \Yii::$app->params['upload']['image'];
			if (!$upload) {
				throw new Exception("文件保存路径错误！", 1);
			}
			$img = UploadedFile::getInstanceByName($fileName);
			$dirPath = $upload .'/'. date('Y').'/'.date('m');
			// 递归创建文件夹
			if (!is_dir($dirPath)) {
	            @mkdir($dirPath, 0777, true);
	        }
	        $file = $dirPath . '/' . $img->name;
	        if (!$img->saveAs($file)) {
	        	throw new Exception("文件上传失败！", 1);
	        }
	        // 修改权限
			if (is_file($file)) {
				@chmod($file, 0777);
			}
	        return true;
		} catch (Exception $e) {
			\Yii::error($e->getMessage());
			return false;
		} 
	}

	/**
	 * 多文件上传
	 * @param  $fileName
	 */
	public function moreUpload($fileName)
	{
		try {
			$upload = \Yii::$app->params['upload']['image'];
			if (!$upload) {
				throw new Exception("文件保存路径错误！", 1);
			}
			$imgObj = UploadedFile::getInstancesByName($fileName);
			$dirPath = $upload .'/'. date('Y').'/'.date('m');
			// 递归创建文件夹
			if (!is_dir($dirPath)) {
	            @mkdir($dirPath, 0777, true);
	        }
	        foreach ($imgObj as $i => $value) {
	        	$file = $dirPath . '/' . ($i+1) .$value->name;
	        	$res = $value->saveAs($file);
	        	// 修改权限
	        	if ($res && is_file($file)) {
	        		@chmod($file, 0777);
	        	} else {
	        		\Yii::error('文件：'.json_encode($value).'上传失败！');
	        	}
	        }
	        return true;
		} catch (Exception $e) {
			\Yii::error($e->getMessage());
			return false;
		}
	}
}