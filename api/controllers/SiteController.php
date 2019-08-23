<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use api\controllers\ApiBaseController;
use common\services\UploadService;

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
        //UploadService::singleUpload('image');
        echo '1111';
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
