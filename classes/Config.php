<?php
class Config {
	//static method
	public static function get($path = NULL){
		if($path){
			$config = $GLOBALS['config'];

			$path = explode( '/', $path );

			//print_r($path);
			foreach ($path as $bit ) {
				if(isset($config[$bit])) {
					//if the first array is set the sey the second array value
					$config = $config[$bit];
				}
			}

			return $config;
		}
		return false;
	} 
}