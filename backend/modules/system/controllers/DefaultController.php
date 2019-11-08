<?php

namespace backend\modules\system\controllers;

use yii\web\Controller;
use backend\models\searches\AdminSearch;

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
    	$searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
