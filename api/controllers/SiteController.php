<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use api\controllers\ApiBaseController;
use yii\web\UploadedFile;

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
        $upload = \Yii::$app->params['uploadPath'];
        $img = UploadedFile::getInstanceByName('image');
        $filename = $upload .'/'. date('Y').'/'.date('m');
        if (!is_dir($filename)) {
            @mkdir($filename, 0777, true);
        }
        $filename .= '/'.$img->name;
        $img->saveAs($filename);
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
