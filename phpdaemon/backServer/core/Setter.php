<?php

	/**
	 * 更改命令的状态
	 * @author istrone
	 *
	 */
	class Setter {
		
		/**
		 * 执行完成以后更新状态
		 * @param int $id
		 */
		public static function executeFinished($id) {
			$db = BackServer::GetDB();
			$tbName = BackServer::getConfigItem('commandTableName');
			$db->update($tbName,array('status'=>Command::STATUSFINISHED),'id='.$id);
		}
		
	}