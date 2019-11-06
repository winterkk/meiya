<?php

namespace backend\modules\system\controllers;

class ArtController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
