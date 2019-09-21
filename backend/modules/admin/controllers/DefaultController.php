<?php

namespace backend\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
	public $enableCsrfValidation = false;
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	if (Yii::$app->request->isPost) {
    		// var_dump(Yii::$app->request);exit;
    		$data = [
	    		//{"id":1, "username":"zhangsan", "six":0, "score":102}
	    		['id'=>1,'username'=>'zhangsan','six'=>0,'score'=>102],
	    		['id'=>2,'username'=>'zhangsan2','six'=>1,'score'=>2],
	    		['id'=>3,'username'=>'zhangsan3','six'=>2,'score'=>1042],
	    		['id'=>4,'username'=>'zhangsan4','six'=>1,'score'=>902],
	    	];
	    	$resp = \Yii::$app->response;
	        $resp->format = Response::FORMAT_JSON;
	        $resp->data = ['data' => $data , 'code'=>0];
	        return $resp;
    	} else {
    		return $this->render('index');
    	}
        
    }
}
