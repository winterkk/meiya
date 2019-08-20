<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use api\controllers\ApiBaseController;

/**
 * Site controller
 */
class SiteController extends ApiBaseController
{
    // close model
    public $modelClass = false;

    /**
     * Displays homepage.
     * 
     * @return 
     */
    public function actionHome()
    {
        // banner

        // style
    }

    /**
     * picture store
     *
     * @return 
     */
     public function actionPicStore()
     {
        // content

        // list
     }

     /**
      * picture detail
      *
      * @return 
      */
     public function actionPicDetail()
     {
        // detail

        // recommend
     }

}
