<?php

namespace backend\modules\system\controllers;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
