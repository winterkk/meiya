<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use api\controllers\ApiBaseController;
use yii\imagine\Image;

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
        $src = '/www/php/meiya/api/web/images/lb.jpg';
        // banner
        var_dump(file_get_contents($src));
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
