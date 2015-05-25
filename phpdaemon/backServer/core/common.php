<?php

if(!function_exists('back_config_item')){
	
	/**
	 * 获得配置信息
	 */
	function back_config_item($k){
		$items = BackServer::getConfigItem('params');
		if(isset($items[$k])) {
			return $items[$k];
		}
	}
}


if(!function_exists('__autoload')) {	
	/**
	 * 自动加载
	 * @param string $class_name
	 */
	function __autoload($class_name) {
		include $class_name . '.php';
	}
}