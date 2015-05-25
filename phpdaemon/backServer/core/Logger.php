<?php

	class Logger {
	
		private $_logpath;
		
		public function __construct() {
			$this->_logpath = COMMAND_PATH . 'commands/logs/';
		}
		
		public function addLog($level,$message){
			$fileName = $this->getLogFileName();
			$message =	date('Y-m-d H:i:s') . "\t" . $level . "\t" . $message . "\n";
			$fp = fopen($fileName,'a');
			fwrite($fp, $message);
			fclose($fp);
		}
		
		
		
		private function getLogFileName() {
			$d = date('Ymd');
			if (!file_exists($this->_logpath.$d)) {
				file_put_contents($this->_logpath.$d, '');
			}
			return $this->_logpath . $d;
		}
	}
