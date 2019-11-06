<?php

namespace backend\modules\system\controllers;

use yii\web\Controller;

/**
 * Default controller for the `system` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$this->getView()->title='默认';
        return $this->render('index');
    }
}
