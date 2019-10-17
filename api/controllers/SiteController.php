<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use api\controllers\BaseController;
use api\models\ApiArtClasses;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    // close model
    public $modelClass = false;

    /**
     * Displays homepage.
     * 
     * @return 
     */
    public function actionDefault()
    {
        // class
        $_classes = new ApiArtClasses();
        $classes = $_classes->getArtClasses();
        return $this->success('查询成功！',$classes);
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
