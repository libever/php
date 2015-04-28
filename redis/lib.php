<?php

class own_redis{

	public static $redis = null;

	public function __construct($host = 'localhost',$port = 6379){
		if(self::$redis == null){
			self::$redis = new Redis();	
			self::$redis->connect($host,$port);
		}
	}

	public function kset($name,$value){
		self::$redis->set($name,$value);	
	}

	public function kget($name){
		return self::$redis->get($name);	
	}
	
	public function zadd($zname,$key,$v){
		return self::$redis->zAdd($zname,$v,$key);	
	}

	public function zrange($zname,$offset,$limit,$withscores){
		return self::$redis->zRange($zname,$offset,$limit,$withscores);	
	}

	public function __destruct(){
		self::$redis->close();	
	}

}
