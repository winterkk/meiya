<?php
namespace api\controllers;

use Yii;
use api\controllers\BaseController;
use api\models\ApiArtClasses;
use api\models\ApiArtStyles;
use api\models\ApiArtContents;
use api\models\ApiArts;
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
  $classId = \Yii::$app->request->post('classId',0);
// 分类下风格
  $_style = new ApiArtStyles();
  $styles = $_style->getArtClassStyles($classId);
  return $this->success('查询成功！', $styles);
}

/**
* 某一风格下内容
*/
public function actionContents()
{
  $request = \Yii::$app->request;
  $styleId = $request->post('styleId');
  $_cont = new ApiArtContents();
  $contents = $_cont->getArtStyleContents($styleId);
  return $this->success('查询成功！',$contents);
}

/**
* 列表
*/
public function actionList()
{
  $request = \Yii::$app->request;
  $classId = $request->post('classId',0);
  $styleId = $request->post('styleId',0);
  $contId = $request->post('contId',0);

  $page = $request->post('page', 1);
  $limit = $request->post('limit', 20);

// arts list
  $_art = new ApiArts();
  $param = [
    'class' => $classId,
    'style' => $styleId,
    'content' => $contId
  ];
  $count = $_art->getArtCount($param);
  $pages = $this->getPageInfo($page, $limit, $count);
  $offset = ($pages['page'] - 1) * $limit;
  $arts = $_art->getArtList($param, $offset, $limit);
  $items = [];
  if (!empty($arts)) {
    foreach ($arts as $key => $art) {
      $t = [];
      $t['artId'] = $art->id;
      $t['title'] = $art->title;
      if (!empty($art->coverImg)) {
        $img = $art->coverImg;
        $height = $img->width;
        $width = $img->height;
        $url = CommonService::getImageUrl($img->path);
      } else {
        $height = 0;
        $width = 0;
        $url = '';
      }
      $t['height'] = $height;
      $t['width'] = $width;
      $t['url'] = $url;
      $items[] = $t;
    }
  }
// 导航
  $path = [];
  if ($classId) {
    $_class = new ApiArtClasses();
    $path = $_class->getClassNav($classId);
  } 
  if ($styleId) {
    $_style = new ApiArtStyles();
    $path = $_style->getStyleNav($styleId);
  }
  if ($contId) {
    $_cont = new ApiArtContents();
    $path = $_cont->getContentNav($contId);
  }
// response
  $data = [
    'path' => $path,
    'pages' => $pages,
    'itmes' => $items
  ];
  return $this->success('查询成功！', $data);
}

/**
* 详情页
*/
public function actionDetail()
{
  $id = \Yii::$app->request->get('id');
  
}

}