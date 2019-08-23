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
        $img = \Yii::$app->params['upload']['imageUrl'].'2019/08/zhhs.jpg';
        // http://local.img.my.com/images/2019/08/zhhs.jpg
        echo '<img src="'.$img.'">';
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
