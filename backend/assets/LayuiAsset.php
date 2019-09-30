<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * layui asset bundle
 */

class LayuiAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		'layui/css/layui.css',
		'layui/css/admin.css'
	];

	public $js = [
		'layui/layui.js'
	];

	public $depends = [];

	/**
	 * 按需加载js文件
	 */
	public static function addScript($view, $jsfile) {  
        $view->registerJsFile($jsfile, [AppAsset::className(), 'depends' => 'backend\assets\LayuiAsset']);  
    }

    /**
     * 按需加载css文件
     */
    public static function addCss($view, $cssfile) {
    	$view->registerCssFile($cssfile, [AppAsset::className(), 'depends' => 'backend\assets\LayuiAsset']);
    }
}