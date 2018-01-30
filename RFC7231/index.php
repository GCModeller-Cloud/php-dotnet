<?php

class Error {
	
	public static function getPath($code) {
		return dirname(__FILE__) . "/$code.html";
	}
	
	private static function display($code) {
		header(Error::getRFC($code));
		echo file_get_contents(Error::getPath($code));
	}
	
	private static function getRFC($code) {
		switch ($code) {
			case 404:
				return "HTTP/1.0 404 Not Found";
				break;
			case 403:
				return "HTTP/1.0 403 Forbidden";
				break;
			case 500:
				return "HTTP/1.0 500 Internal Server Error";
				break;
		}
	}
	
	public static function err404() {
		echo file_get_contents(Error::getPath(404));
	}
	
	public static function err403() {
		echo file_get_contents(Error::getPath(403));
	}
	
	public static function err500() {
		echo file_get_contents(Error::getPath(500));
	}
}

?>