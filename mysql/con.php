<?php

class own_mysql {

	private static $mysql_con  = null;

	public function __construct($host,$uid,$password){
		if(self::$mysql_con == null){
			self::$mysql_con = mysql_connect($host,$uid,$password);	
		}
	}

	public function __destruct(){
		mysql_close(self::$mysql_con);	
	}
}
