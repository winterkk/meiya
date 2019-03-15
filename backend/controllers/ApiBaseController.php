<?php
/**
 * BaseController
 * Date:2018/11/5
 */
namespace backend\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * Default controller for the `modules` module
 */
class ApiBaseController extends ActiveController
{
    public $actions = [];

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带方法
        unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }
    
    /**
     * 前置动作
     * @param  $action
     * @return  boolean
     */
    public function beforeAction($action)
    {
        //跨域
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:POST,GET");
        header("Access-Control-Allow-Headers:x-requested-with,content-type,Authorization");

        // free actions
        $freeAction = ['login'];
        if (in_array($action->id, $freeAction)) {
            return true;
        }
        // token
        $headers = \Yii::$app->request->headers;
        if ($headers->has('Authorization') && strlen($headers->get('Authorization')) > 0) {
            $token = $headers->get('Authorization');
            if ($this->checkToken($token)) {
                return true;
            } else {
                $this->error('1002');
            }
        } else {
            // free actions
            $freeActionOther = ['show', 'list', 'art-show'];
            if (in_array($action->id, $freeActionOther)) {
                return true;
            } else {
                $this->error('1001');
            }
        }
        return true;
    }

    /**
     * 后置动作
     * @param  $action
     * @param  $result
     */
    public function afterAction($action, $result)
    {
        parent::afterAction($action, $result);
    }

    /**
     * success
     * @param  $datra
     * @date  2018-11
     */
    public function success($data=[])
    {
        return $this->jsonResponse('200', $data);
    }

    /**
     * error
     * @param  $code
     */
    public function error($code='404',$data=[])
    {
        if (empty($data)) {
            return $this->jsonResponse($code, $this->errorMsg($code));
        } else {
            return $this->jsonResponse($code, $data);
        }
        
    }

    /**
     * 返回json数据
     * @param  $code  编码
     * @param  $data  返回数据
     * @return  json
     */
    protected function jsonResponse($code, $data)
    {
        $resp = \Yii::$app->response;
        $resp->format = Response::FORMAT_JSON;
        $resp->data = ['code' => $code, 'info' => $data];
        return $resp;
    }

    /**
     * 错误提示
     * @param  $code 
     * @return  string
     */
    protected function errorMsg($code = '404')
    {
        $errorBox = [
            '404' => '页面不存在',
            '1001' => '无效请求',
            '1002' => 'token验证失败',
            '1003' => '操作失败',

            '1010' => '管理员账号不存在！',
            '1011' => '查询内容不存在',
            '1012' => '禁用类型分类失败',
            '1013' => '内容没有搜索到',
            '1014' => '该内容分类不存在',
            '1015' => '该颜色内容不存在',

            '1021' => '删除图片失败'

        ];
        return isset($errorBox[$code]) ? $errorBox[$code] : '异常错误类型！';
    }

    /**
     * token生成
     * @param  $userId
     * @param  $userName
     * @param  $type  加密方式
     */
    protected function setToken($userId, $userName, $type='sha256')
    {
        // header
        $headerJson = $this->getJWTheader($type);
        $headerStr = base64_encode($headerJson);
        //payload
        // iss：jwt签发者
        // sub：jwt所面向的用户
        // aud：接收jwt的一方
        // exp：jwt的过期时间，这个过期时间必须大于签发时间
        // nbf：定义在什么时间之前，该jwt都是不可用的
        // iat：jwt的签发时间
        // jti：jwt的唯一身份标识，主要用来作为一次性token，从而回避重放攻击 
        $time = time();
        $body = [
            'iss' => 'jujube',
            'sub' => $userName,
            'aud' => 'jujube wechat app',
            'exp' => $time + 3600 * 24 * 30,
            'nbf' => $time,
            'iat' => $time,
            'jti' => $userId
        ];
        $body = json_encode($body);
        $payload = base64_encode($body);
        // sign
        $secret = \Yii::$app->params['tokenSecret'];
        $sign = hash($type, $headerStr . $payload . $secret);
        // return
        return $headerStr . '.' . $payload . '.' . $sign;
    }

    /**
     * token验证
     * @param  $token
     * @return  
     */
    protected function checkToken($token)
    {
        $info = explode('.', $token);
        if (!isset($info[0]) || !isset($info[1]) || !isset($info[2])) {
            return false;
        }
        // check
        $headerArr = json_decode(base64_decode($info[0]), true);
        $type = $headerArr['alg'];
        $secret = \Yii::$app->params['tokenSecret'];
        $checkStr = hash($type, $info[0] . $info[1] . $secret); 
        if ($checkStr != $info[2]) {
            return false;   //验签失败
        } else {
            // 信息解析
            $body = json_decode(base64_decode($info[1]), true);
            $time = time();
            if ($time < $body['nbf'] || $time > $body['exp']) {
                return false;   //超时
            }
            $_POST['userId'] = $body['jti'];
            $_POST['userName'] = $body['sub'];
            return true;
        }
    }

    /**
     * 获取JWT加密方式
     * @param 
     */
    protected function getJWTheader($type='sha256')
    {
        return json_encode(['typ'=>'JWT','alg'=>$type]);
    }

    /**
     * 分页信息
     * @param  $page
     * @param  $limit
     * @param  $count
     */
    public function getPageInfo($page=1, $limit=20, $count=0)
    {
        $page = $page > 0 ? floor($page) : 1;
        $limit = $limit > 0 ? floor($limit) : 20;
        // 获取总数
        if ($count <= 0) {
            $count = 0;
        }
        $pageCount = ceil( $count / $limit );
        if ($pageCount < 1) {
            $pageCount = 1;
        }
        $nextPage = $page + 1;
        if ($pageCount <= $nextPage) {
            $nextPage = $pageCount;
        }
        $prePage = $page - 1;
        if ($prePage < 1) {
            $prePage = 1;
        }
        if ($page >= $nextPage) {
            $page = $nextPage;
        }
        if ($page <= $prePage) {
            $prePage = $page;
        }
        $data = [
            'page' => $page,
            'limit' => $limit,
            'nextPage' => $nextPage,
            'prePage' => $prePage
        ];
        return $data;
    }
}
