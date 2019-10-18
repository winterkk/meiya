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
        $list = [
            [
                'id' => 1,
                'titile' => 't1',
                'pid' => 0
            ],
            [
                'id' => 2,
                'titile' => 't2',
                'pid' => 0
            ],
            [
                'id' => 3,
                'titile' => 't3',
                'pid' => 1
            ],
            [
                'id' => 4,
                'titile' => 't4',
                'pid' => 1
            ],
            [
                'id' => 5,
                'titile' => 't5',
                'pid' => 2
            ],
            [
                'id' => 6,
                'titile' => 't6',
                'pid' => 2
            ],
            [
                'id' => 7,
                'titile' => 't7',
                'pid' => 3
            ],
            [
                'id' => 8,
                'titile' => 't8',
                'pid' => 7
            ],
            [
                'id' => 9,
                'titile' => 't5',
                'pid' => 8
            ],
            [
                'id' => 10,
                'titile' => 't6',
                'pid' => 9
            ],
            [
                'id' =>11,
                'titile' => 't7',
                'pid' => 10
            ],
            [
                'id' => 12,
                'titile' => 't8',
                'pid' => 11
            ]
        ];
        $tree = CommonService::makeTree($list);
        echo '<pre>';
        print_r($tree);exit;
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
