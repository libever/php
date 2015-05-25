<?php if(!defined('COMMAND') && define('COMMAND','COMMAND')) return ;

	class Command {
		
		/**
		 * 命令状态
		 * @var int
		 */
		const STATUSFINISHED = 0;
		const STATUSRUNNING = 1;
		const STATUSBEGIN = -1;
		
		/**
		 * 命令类型
		 * @var int
		 */
		const CommandFunction = 0;
		const CommandMethod = 1;
		
		public $id;
		
		private $class;
		
		private $function;
		
		private $method;
		
		private $params;
		
		private $commandType = self::CommandFunction;
		
		private $faiedCommand = NULL;
		
		private $successCommand = NULL;
		
		public static function  createFunctionCommand($function,$params = array(),$success = NULL , $failed = NULL) {
			$cmd = new Command();
			$cmd->function = $function;
			$cmd->params = $params;
			$cmd->successCommand = $success;
			$cmd->faiedCommand = $failed;
			return $cmd;
		}
		
		public static function createMethodCommand($class,$method,$params=array(),$success = NULL , $failed = NULL){
			$cmd = new Command();
			$cmd->commandType = self::CommandMethod;
			$cmd->class = $class;
			$cmd->method = $method;
			$cmd->params = $params;
			return $cmd;
		} 

		private function __construct(){}
		
		public function execute(){	
			if($this->commandType == self::CommandFunction ) {
				include COMMAND_PATH . 'commands/functionCommands.php';
				$fun = $this->function;
				$params = $this->params;
				if(function_exists($fun)) {
					$retsult = $fun($params);
					if($retsult && $this->successCommand ) {
						$this->successCommand->execute();		
					}
					if(!$retsult && $this->faiedCommand ) {
						$this->faiedCommand->execute();
					}
				}else{
					BackServer::addLog('error', '没有你需要定义的函数！'.$fun);
				}
			}else {
				include COMMAND_PATH . 'commands/methodCommands.php';
				$c = $this->class;
				$m = $this->method;
				if(class_exists($c) && method_exists($c, $m)){
					$c = new $c();
					$retsult = $c->$m($this->params);
					if($retsult && $this->successCommand ){
						$this->successCommand->execute();
					}
					if($retsult && $this->faiedCommand ) {
						$this->faiedCommand->execute();
					} 
				}else{
					BackServer::addLog('error', 'OH,My god!你调用的方法，俺也没有啊？！'.$c.'->'.$m);
				}
			}
		}
		
	}