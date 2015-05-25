<?php

	class Utils {
		
		
		/**
		 * 垃圾命令处理器
		 */
		public static function GC(){
			$i = rand(1, 100);
			if($i <= BackServer::getConfigItem('clearFrequency')){
				self::_clearCommond();
			}
		}
		
		
		 /**
		 * 清除指令
		 */
		private static function _clearCommond(){
			$db = BackServer::GetClass('DB');
			$tbName = BackServer::getConfigItem('commandTableName');
			$db->delete($tbName,'status = ' . Command::STATUSFINISHED);
		}
		
	}