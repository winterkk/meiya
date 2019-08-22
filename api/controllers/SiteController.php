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
        $newSrc = '/www/php/meiya/api/web/images/lb-375.jpg';
        Image::thumbnail($src,375,null)->save($newSrc,['quality'=>100]);
        echo 'success';
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
