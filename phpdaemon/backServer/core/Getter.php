<?php	if(!defined('GETTER') && define('GETTER','GETTER')) return ;

	class Getter {
		
		private $_db;
		
		private $_commandTableName;
		
		private $_parser ;
		
		public function __construct(){
			$this->_db = BackServer::GetClass('DB');
			if(! $this->_commandTableName = BackServer::getConfigItem('commandTableName') ) {
				$this->_commandTableName = 'cms_command';
			}
			$c = BackServer::getConfigItem('CommandParser');
			$this->_parser =BackServer::GetClass($c);
		}
		
		/**
		 * 获得一条命令
		 */
		public function getCommand(&$id){
			$item = $this->_db->getItem($this->_commandTableName,'status = '. Command::STATUSBEGIN);
			if($item)
				return $this->_parser->parseCommand($item,&$id);
		}
		
	}