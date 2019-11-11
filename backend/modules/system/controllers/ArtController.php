<?php

namespace backend\modules\system\controllers;

use backend\models\searches\ArtSearch;

class ArtController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$this->getView()->title = '标题';
    	$model = new ArtSearch();
    	$request = \Yii::$app->request->queryParams;
    	$dataProvider = $model->search($request);
        return $this->render('index',['dataProvider'=>$dataProvider,'model'=>$model]);
    }

}
