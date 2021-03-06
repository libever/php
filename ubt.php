<?php 

function get_fun_src($fun){
	$cf = new ReflectionFunction($fun);
	return $cf->getFileName();
}

function get_obj_src($class){
	$cf = new ReflectionClass($class);
	return $cf->getFileName();
}

function ubt(){
	$str = "";
	$backTrace = debug_backtrace();
	unset($backTrace[0]);
	foreach ( $backTrace  as $backItem ) {
		$className = isset($backItem['class']) ? $backItem['class'] : '';
		$str .= $backItem['file'] . "\t";
		$str .= $backItem['line'] . "\t";
		$str .= $backItem['function'] . "\t";
		$str .= $className . "\t";
		$str .= "\n";
	}
	return $str;
}
