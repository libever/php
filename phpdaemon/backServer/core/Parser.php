<?php
	
	/**
	 * 命令解析器
	 * @author istrone
	 */
	class Parser {
		
		/**
		 * 解析指令
		 * @param array $item
		 */
		public function parseCommand($item,&$id){
			$run = unserialize($item['run']);
			$success = unserialize($item['success']);
			$failed = unserialize($item['failed']);
			$id = $item['id'];
			$runCommand = $this->_parseCommand($run);
			if($runCommand) {
				if( $success = $this->_parseCommand( $success )) $runCommand->success = $success;
				if( $success = $this->_parseCommand( $failed )) $runCommand->failed = $failed; 
			}
			return $runCommand;
		}
		
		/**
		 * 按串行化解析
		 * @param array $item
		 */
		private function _parseCommand($item) {
			if( $item ){
				if($item['type'] == Command::CommandFunction) {
					return Command::createFunctionCommand($item['function'],$item['params']);
				}else{
					return Command::createMethodCommand($item['class'], $item['method'],$item['params']);
				}
			}
		}
		
	}
	
	
	/**
	 * 	type:method,function
	 *  class  method params
	 *  function params
	 */