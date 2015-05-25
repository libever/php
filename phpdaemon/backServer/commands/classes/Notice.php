<?php

if(!defined('Notice'))
{

	class Notice {
		
		const CHECKED = 1;
		const UNCHECKED = 0;
		
		/**
		 * 给用户发送一条通知
		 * @param int $id
		 * @param string $message
		 * id,message
		 */
		public function AddNotice($params = array()) {
			BackServer::GetClass('SysDate');
			extract($params);
			$db = BackServer::GetDB();
			$db->addItme('cms_notice', array('userid'=>$id,'notice'=>$message,'checked'=>self::UNCHECKED,'sendtime'=>SysDate::now()));
		}
		
	}

	
	define('Notice', 'Notice');
	
}