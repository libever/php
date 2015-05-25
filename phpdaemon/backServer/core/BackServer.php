<?php  if(!defined('BACKSERVER') && define('BACKSERVER', 'BACKSERVER')) return ;

	
	/**
	 *  后台主服务程序
	 * @author istrone
	 */
	class BackServer {
		
		/**
		 * 配置信息
		 * @var array
		 */
		private static $_config;
		
		private static $instance;
		
		/**
		 * 获得配置项
		 * @param string $itemName
		 */
		public static function getConfigItem($itemName){
			if (self::$_config && isset(self::$_config[$itemName])) {
				return self::$_config[$itemName];
			}
		}
		
		/**
		 * 获得一个实例
		 * @param array $config
		 */
		public static function getInstance($config){
			if(!self::$instance) {
				self::$instance = new BackServer($config);
			}
			return self::$instance;
		}
		
		private function __construct($config){
			require SYSPATH . 'common.php';
			self::$_config = $config;
		}
		
		/**
		 * 获得一条命令,执行一条命令
		 */
		public function run(){
			$getter = new Getter();	
			$id = 0;
			if($cmd = $getter->getCommand(&$id)){
				$cmd->execute();
				Setter::executeFinished($id);
			}
			Utils::GC();
		}
		
		/**
		 *外部用来加载核心类 
		 * @param string $c
		 */
		public static function GetClass($c,$params = array()){
			if($c == 'DB') return DB::getInstance($params);
				else return new $c($params);
		}
		
		/**
		 * 加载数据库
		 * @param array $config
		 */
		public static function GetDB($config = array()){
			return self::GetClass('DB',$config);
		}
		
		/**
		 * 添加一条日志信息
		 * @param string $level 错误级别
		 * @param string $message 日志信息
		 */
		public static function  addLog($level,$message) {
			$logger = self::GetClass('Logger');
			$logger->addLog($level,$message);
		} 
		
		/**
		 * 包含一个
		 * @param string $location 路径地址
		 */
		public static function includeFiles($location){
			$directory = opendir($location);
			while($file = readdir($directory)) {
				if( $file != '.' && $file != '..' ) {
					$hz = substr($file, strlen($file)-4);
					if($hz  == '.php') {
						include $location. '/' .$file;
					}
				}
			}
        	closedir($directory);
		}
		
		/**
		 * 退出系统执行
		 */
		public static function Bexit(){
			exit();
		}
		
	}


	