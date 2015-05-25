<?php

	/**
	 * 日期处理类
	 * 主要是相对于当前
	 * @author istrone
	 *
	 */
	class SysDate  {
		
		//现在时间
		private static $_now;
		
		//输出格式
		private static $format = 'Y-m-d H:i:s';
		
		//获得当前时间
		public static function now(){
			self::selfInit();
			return self::$_now;
		}
		
		/**
		 * 加上几秒钟
		 * @param int $s 
		 */
		public static  function addSeconds($s){
			self::selfInit();
			$d = strtotime(self::$_now);
			return date(self::$format,$d+$s);
		}
		
		/**
		 * 加上几分钟
		 * @param int $m
		 */
		public static function addMinutes($m){
			return self::addSeconds($m*60);
		}
		
		/**
		 * 加上几小时
		 * @param int $h
		 */
		public static function addHours($h){
			return self::addMinutes($h*60);
		}
		
		/**
		 * 加上几天
		 * @param int $d
		 */
		public static function addDays($d) {
			return self::addHours($d * 24);
		}
		
		/**
		 * 添加一段时间
		 * @param int $d 天数
		 * @param int $h 小时数
		 * @param int $m 分钟数
		 * @param int $s 秒数
		 */
		public static function addTimes($d,$h,$m,$s){
			return self::addSeconds($d*3600*24+$h*3600+$m*60+$s);
		}
		
		/**
		 * 设置日期的格式
		 */
		public	static function setFormat($format){
			self::$format = $format;
		}
		
		/**
		 * 设置时间
		 * @param int $timestap 时间戳
		 */
		public static function setNowTime($timestap){
			self::$_now = date(self::$format,$timestap);
		}
		
		/**
		 * 初始化为当前时间
		 */
		private static function selfInit(){
			if(self::$_now == NULL) {
				self::$_now = date(self::$format);
			}
		}
	
	}