<?php
namespace api\controllers;

use Yii;
use api\controllers\BaseController;
use api\models\ApiArtClasses;
use api\models\ApiArtStyles;
use api\models\ApiArtContents;
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
        $thumb = CommonService::setImgThumb('image');
        var_dump($thumb);
    }

    /**
     * 分类
     */
    public function actionClasses()
    {
        $_classes = new ApiArtClasses();
        $classes = $_classes->getArtClasses();
        return $this->success('查询成功！',$classes);
    }

    /**
     * 某一分类下风格
     */
    public function actionStyles()
    {
        $request = \Yii::$app->request;
        $classId = $request->post('classId');
        if (!$classId) {
            return $this->error('10001','查询失败！');
        }
        
        // 分类下风格
        $_style = new ApiArtStyles();
        $styles = $_style->getArtClassStyles($classId);

        // arts list
        $_art = new ApiArts();
        $count = $_art->getArtCount($classId);
        $arts = $_art->getArtList();
        return $this->success('查询成功！', ['styles'=>$styles,'items'=>$items]);
    }

    /**
     * 某一风格下内容
     */
    public function actionContents()
    {
        $request = \Yii::$app->request;
        $styleId = $request->post('styleId');
        if ($styleId) {
            $_cont = new ApiArtContents();
            $contents = $_cont->getArtStyleContents($styleId);
        } else {
            $contents = [];
        }
        return $this->success('查询成功！',$contents);
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
