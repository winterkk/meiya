<?php
/**
 * 公共类
 * @date  2018-11
 */
namespace common\services;

use Yii;
use common\services\ImageProcessService;

class CommonService
{
	/**
	 * 验证密码
	 * 最少6位，包括至少一个大写字母，一个小写字母，一个数字，一个特殊字符
	 * @param  $passwd
	 * @return  boolean
	 */
	public static function checkPasswd($passwd)
	{
		return preg_match('/^.*(?=.{6,})(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#%^&*_+-=]).*$/', $passwd);
	}

	/**
	 * 密码加密
	 * @param  $passwd
	 * @return  string
	 */
	public static function hashPasswd($passwd)
	{
		$passwd = strtoupper(strrev($passwd));
		$passwd = hash('sha256', $passwd);
		return $passwd;
	}

	/**
	 * 验证手机号
	 * @param  $phone
	 * @return  boolean
	 */
	public static function checkPhone($phone)
	{
		return preg_match('/^(13[0-9]|14[0-9]|15[0-9]|16[6]|17[0-8]|18[0-9]|19[89])\d{8}$/', $phone);
	}

	/**
	 * 获取图片的完整地址
	 * @param  $path  相对路径
	 * @param  $host  自定义host
	 * @return  $url
	 */
	public static function getImageUrl($path, $host='')
	{
		if (!$path) {
			return $path;
		}
		// 自定义
		if ($host) {
			return $host . $path;
		}
		// 系统定义
		if (substr($path, 0, 4) == 'http') {
			$url = $path;
		} else {
			$baseHost = \Yii::$app->request->getHostInfo();
			$paramHost = isset(\Yii::$app->params['imageHost']) ? \Yii::$app->params['imageHost'] : '';
			if (($baseHost != $paramHost) && ($paramHost != '')) {
				$url = $paramHost . $path;
			} else {
				$url = $baseHost . $path;
			}
		}
		return $url;
	}

	/**
	 * 获取图片相对路径
	 * @param  $url  图片地址
	 * @param  $host  自定义host
	 * @return  $path
	 */
	public static function getImagePath($url, $host='')
	{
		if (!$host) {
			$host = \Yii::$app->request->getHostInfo();
			$paramHost = isset(\Yii::$app->params['imageHost']) ? \Yii::$app->params['imageHost'] : '';
			if (($host != $paramHost) && ($paramHost != '')) {
				$host = $paramHost;
			} 
		}

		$pos = strpos($url, $host);
		if ($pos === false) {
			$path = $url;
		} else {
			$path = substr($url, $pos + strlen($host));
		}
		return $path;
	}

	/**
	 * 多级菜单
	 * @param  $list  一维数组
	 * @param  $pk  主键id
	 * @param  $pid  父级
	 * @param  $child  子级别
	 * @param  $level  级别
	 */
	public static function makeTree($list, $pk='id', $pid='pid', $child='_child', $level=0)
	{
		// 递归
		// $tree = [];
		// foreach ($list as $key => $value) {
		// 	if ($value[$pid] == $level) {
		// 		$tree[$value[$pk]] = $value;
		// 		unset($list[$key]);
		// 		$tree[$value[$pk]][$child] = self::makeTree($list,$pk,$pid,$child,$value[$pk]);

		// 	}
		// }

		// 引用
  		$tree = [];
  		$data = [];
  		foreach ($list as $key => $value) {
  			$data[$value[$pk]] = $value;
  		}
  		foreach ($data as $key => $value) {
  			$root = $value[$pid];
  			if ($root == $level) {
  				$tree[] = &$data[$key];
  			} else {
  				$data[$root][$child][] = &$data[$key];
  			}
  		}
		return $tree;
	}

	/**
	 * 生成缩略图
	 * @param  $image  上传文件名
	 * @param  $w  缩略图保存宽度
	 * @param  $saveImgFile  是否保留原图
	 * @return  array
	 */
	public static function setImgThumb($image, $w = [236,320,768,1024], $saveImgFile = true)
	{
		if (!$_FILES[$image] || empty($w)) {
			return [];
		}
		$image = $_FILES[$image];
		$type = $image['type'];
		$tmpFile = $image['tmp_name'];
		$fullName = $image['name'];
		$name = strstr($fullName, '.', true);
		$suffix = strstr($fullName, '.');

		// 压缩比率
		list($width, $height, $typeNumber, $attr) = getimagesize($tmpFile);
		$scale = $height / $width;
		$h = [];
		sort($w);
		foreach ($w as $key => $value) {
			if ($value < 300) {
				$h[$key] = $value;
			} else {
				$h[$key] = ceil($value * $scale);
			}
		}

		// save path
		$upload = \Yii::$app->params['upload']['image'];
		$path =  date('Y') . '/' . date('m') . '/' . date('d');
		$dirPath = $upload . $path;
		if (!is_dir($dirPath)) {
			@mkdir($dirPath, 0777, true);
		}

		// thumb
		foreach ($w as $k => $v) {
			$fileName = $name . '-' . $v . 'x' . $h[$k] . $suffix;
			$saveImg = $dirPath . '/' . $fileName;
			ImageProcessService::imgThumb($tmpFile, $saveImg, $v, $h[$k], 'outbound');
			$thumb[] = [
				'width' => $v,
				'height' => $h[$k],
				'file' => $path . '/' . $fileName,
				'type' => $type,
				'md5' => self::md5file($saveImg)
			];
		}

		// 保存原图
		if ($saveImgFile) {
			$saveImage = $dirPath . '/' . $fullName;
			move_uploaded_file($tmpFile, $saveImage);
			$thumb['master'] = [
				'width' => $width,
				'height' => $height,
				'file' => $path . '/' . $fullName,
				'type' => $type,
				'md5' => self::md5file($saveImage)
			];
		}

		// response
		return $thumb;
	}

	/**
	 * 对文本文件的md5散列
	 * @param  $filename  文件路径
	 */
	public static function md5file($filename)
	{
		return md5_file($filename);
	}


	/**
	 * 输入内容简单过滤
	 * @param  max
	 * @return  max
	 */
	public static function simpleTransfer($params)
	{
		if (is_string($params)) {
			$resp = htmlspecialchars($params);
			$resp = addslashes($resp);
		} else if (is_array($params) || is_object($params)) {
			foreach ($params as $key => &$value) {
				# code...
				$value = self::simpleTransfer($value);
			}
			$resp = $params;
		} else {
			$resp = $params;
		}
		return $resp;
	}

	/**
	 * 敏感词过滤	
	 * @param  $str
	 * @return  boolean
	 */
	public static function selectBadWords($inputStr)
	{
		$dataPool = require_once(Yii::getAlias('@common/fonts/badwords.php'));
		if (strlen($dataPool) > 0) {
			$dataPool = json_decode($dataPool);
			if (!empty($dataPool)) {
				foreach ($dataPool as $key => $value) {
					$value = trim($value);
					if(preg_match('/'.$value.'/', $inputStr)) {
						return false;
					}
				}
			} else {
				\Yii::error('敏感词库内容缺失！位置:./common/fonts/badwords.php');
			}
		} else {
			\Yii::error('敏感词库文件缺失！位置:./common/fonts/badwords.php');
		}
		return true;
	}

	/**
	 * 简单curl处理
	 * @param  $url  地址
	 * @param  $method  方式[get,post]
	 * @param  $data  post传参
	 * @param  $header  
	 */
	public function useCurl($url, $method='GET', $data=[], $header=[])
	{
		if (!extension_loaded('curl')) {
            \Yii::info('cURL library is not loaded');
        }
        $ch = curl_init();

        //setopt-url
        $url = (string)$url;
        if (strlen($url) < 1) {
            return false;
        }
        if (strtoupper($method) == 'GET') {
            $url = $this->buildUrl($url,$data);
        }
        curl_setopt($ch, CURLOPT_URL, $url);

        //setopt-useragent
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0) Gecko/20100101 Firefox/6.0';
        $user_agent .= ' PHP/' . PHP_VERSION;
        $curl_version = curl_version();
        $user_agent .= ' curl/' . $curl_version['version'];
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

        //setopt-post
        if (strtoupper($method) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_HEADER, false);    //返回不带header头
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);     //链接超时时间
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //curl_exec获取信息以文件流返回,false是直接输出
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);   

        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }     

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($response === false || $info['http_code'] != 200) {
            $data = json_encode($data);
            $log = "No cURL data returned for ".$url.";params:".$data."[".$info['http_code']."]";
            if (curl_error($ch)) {
                $log .= "\r\n".curl_error($ch);
            }
            \Yii::error($log);
        } else {
            $log = json_encode($info).'---'.json_encode($data);
            \Yii::info($log);
        }
        curl_close($ch);

        return $response;
	}

	/**
     * Build Url
     * @access private
     * @param  $url
     * @param  $mixed_data
     * @return string
     */
    private function buildUrl($url, $mixed_data = '')
    {
        $query_string = '';
        if (!empty($mixed_data)) {
            $query_mark = strpos($url, '?') > 0 ? '&' : '?';
            if (is_string($mixed_data)) {
                $query_string .= $query_mark . $mixed_data;
            } elseif (is_array($mixed_data)) {
                $query_string .= $query_mark . http_build_query($mixed_data, '', '&');
            }
        }
        return $url . $query_string;
    }

    /**
     * 时间的中国化展示
     * @param  $times
     * @return  string
     */
    public static function formatDate($times)
    {
    	$format = [
    		'31536000'=>'年',
		    '2592000'=>'个月',
		    '604800'=>'星期',
		    '86400'=>'天',
		    '3600'=>'小时',
		    '60'=>'分钟',
		    '1'=>'秒'
    	];
    	foreach ($format as $key => $value) {
    		$num = floor($times/intval($key));
    		if ($num != 0) {
    			return $num.$value;
    		}
    	}
    }

    /**
     * 按自然月计算vip到期时间
     * @param  $months
     * @param  $starDate
     * @return  时间戳
     */
    public static function getVipEndDate($months,$starDate='')
    {
    	if (!$starDate) {
    		$starDate = date('Y-m-d');
    	}
    	$starTime = strtotime($starDate);
    	// 下个自然月计算
    	$nextMonth = date('m',$starTime) + 1;
    	//当前月剩余时间
    	$nextMonthTime = strtotime(sprintf('%s-%s-01', date('Y') + floor($nextMonth / 12), $nextMonth % 12));
    	$limit =  $nextMonthTime - 24 * 3600 - $starTime;
    	// 月份
    	$months += $nextMonth;
    	$nexMonthsTime = strtotime(sprintf('%s-%s-01', date('Y') + floor($months / 12), $months % 12));
    	$time = $nexMonthsTime - 24 * 3600 - $limit;

    	return $time;
    }
}