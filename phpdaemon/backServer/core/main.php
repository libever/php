<?php

/**
 * 定义命令路径常量
 * @var string
 */
define('COMMAND_PATH',realpath( dirname(__FILE__). '..') );

/**
 * 开启浏览器调试
 * @var boolean
 */
define('WEBDEBUG', FALSE); 

/**
 * 系统路径
 * Enter description here ...
 * @var unknown_type
 */
define('SYSPATH', COMMAND_PATH . 'core/');


/**
 * 主服务程序的入口
 * 利用cron使他类似服务程序似的运行
 */
function main(){
	
	$config = include 'commands/commands.cofig.php';
	
	include SYSPATH.'BackServer.php';
	
	if(WEBDEBUG){
		set_time_limit(0);#!/usr/bin/php
		BackServer::getInstance($config)->run();
		BackServer::Bexit();
	}
	
	if($pid = pcntl_fork() == 0) {
		//first child process
		posix_setsid();		//脱离开主程序控制
		if($pid2 = pcntl_fork() == 0 ) {
			//second child process
			if(defined('STDIN')) {
				file_put_contents(COMMAND_PATH . 'runtime/backServer.pid', posix_getpid());	//当前进程的pid写入文件	
				while(true){
					BackServer::getInstance($config)->run();
					sleep(BackServer::getConfigItem('everySleepSeconds'));
				}
			}
		}else {
			exit();
		}

	} else {
		exit();
	}
}

main();
