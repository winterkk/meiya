<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use api\controllers\BaseController;
use api\models\ApiArtClasses;
use api\models\ApiArtStyles;
use common\services\CommonService;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    // close model
    public $modelClass = false;

    /**
     * Displays homepage.
     * @return 
     */
    public function actionDefault()
    {

    }

    /**
     *
     *
     */
    public function actionClasses()
    {
        $_classes = new ApiArtClasses();
        $classes = $_classes->getArtClasses();
        return $this->success('查询成功！',$classes);
    }

    /**
     * 风格
     */
    public function actionStyles()
    {
        $request = \Yii::$app->request;
        $classId = $request->post('classId');
        if ($classId) {
            $_style = new ApiArtStyles();
            $styles = $_style->getArtClassStyles($classId);
        } else {
            $styles = [];
        }
        return $this->success('查询成功！', $styles);
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
