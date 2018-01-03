<?php

class Enumerable {
	
	// 请注意这个函数并不会按照字典的key，只会按照value来排序
	public static function OrderBy($array, $key) {		
		$getKey =& $key;

		usort($array, function($a, $b) use (&$getKey) {
			$a = $getKey($a);
			$b = $getKey($b);
			
			if ($a == $b) {
				return 0;				
			} else {
				return ($a < $b) ? -1 : 1;
			}			
		});
		
		return $array;
	}
	
	public static function OrderByDescending($array, $key) {
		return array_reverse(Enumerable::OrderBy($array, $key));		
	}

	public static function OrderByKey($array, $key) { 
		$keys   = array_keys($array);
		$keys   = Enumerable::OrderBy($keys, $key);
		$values = array();

		foreach ($keys as $key) {
			$values[$key] = $array[$key];
		}

		return $values;
	}		

	public static function OrderByKeyDescending($array, $key) { 
		return array_reverse(Enumerable::OrderByKey($array, $key));
	}
}

?>