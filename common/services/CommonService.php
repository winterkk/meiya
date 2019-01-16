<?php
/**
 * 公共类
 * @date  2018-11
 */
namespace common\services;

use Yii;

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
	 * @return  $url
	 */
	public static function getImageUrl($path)
	{
		if (substr($path, 0, 4) == 'http') {
			$url = $path;
		} else {
			$host = \Yii::$app->request->getHostInfo();
			$paramHost = isset(\Yii::$app->params['imageHost']) ? \Yii::$app->params['imageHost'] : '';
			if (($host != $paramHost) && ($paramHost != '')) {
				$url = $paramHost . $path;
			} else {
				$url = $host . $path;
			}
		}
		return $url;
	}

	/**
	 * 获取图片相对路径
	 * @param  $url
	 * @return  $path
	 */
	public static function getImagePath($url)
	{
		$host = \Yii::$app->request->getHostInfo();
		$paramHost = isset(\Yii::$app->params['imageHost']) ? \Yii::$app->params['imageHost'] : '';
		if (($host != $paramHost) && ($paramHost != '')) {
			$host = $paramHost;
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
    	// $nextMonth = date('m',$starTime) + 1;
    	// //当前月剩余时间
    	// $nextMonthTime = strtotime(sprintf('%s-%s-01', date('Y') + floor($nextMonth / 12), $nextMonth % 12));
    	// $limit =  $nextMonthTime - 24 * 3600 - $starTime;
    	// // 月份
    	// $months += $nextMonth;
    	// $nexMonthsTime = strtotime(sprintf('%s-%s-01', date('Y') + floor($months / 12), $months % 12));
    	// $time = $nexMonthsTime - 24 * 3600 - $limit;

    	// 按每月31天计算
    	$time = $starTime + $months * 31 * 24 * 3600;
    	return $time;
    }
}