<?php

class CURLExtensions {

	/**
	 * 模拟提交数据函数
	 * 
	 * @param string $url remote api url
	 * @param array $data 发送的数据包，这里应该是一个[key, value]的键值对字典数组
	 * @param string $userAgent 可以通过这个可选参数进行浏览器模拟
	*/ 
	public static function POST($url, $data = NULL, $userAgent = NULL) { 
		$curl = curl_init(); 
		
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);        // 对认证证书来源的检查
		// PHP Notice:  curl_setopt(): CURLOPT_SSL_VERIFYHOST no longer accepts the value 1, value 2 will be used instead
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);        // 从证书中检查SSL加密算法是否存在

		if (!$userAgent) {
			if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
				// 模拟用户使用的浏览器
				curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
			}
		} else {
			curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); 
		}
		
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);        // 使用自动跳转
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1);           // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1);                  // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);        // Post提交的数据包
		curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt'); // 读取上面所储存的Cookie信息
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);              // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0);                // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);        // 获取的信息以文件流的形式返回
		
		return CURLExtensions::shell($curl);
	}
	
	private static function shell($curl) {
		$tmpInfo = curl_exec($curl);  
		
		if (curl_errno($curl)) {
			if (IS_CLI && FRAMEWORK_DEBUG) {
				# 输出错误信息
				echo 'Errno\n\n' . curl_error($curl);
			}
		}
		curl_close($curl);
		
		return $tmpInfo; 
	}
	
	public static function GET($url, $data = NULL) {
		$res = curl_init($url);
		
		curl_setopt($res, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($res, CURLOPT_BINARYTRANSFER, true);

		return CURLExtensions::shell($res);
	}
}

?>