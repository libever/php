<?php if(!defined('DB') && define('DB','DB')) return;

class DB {

	private $_connnection;

	private static $instance;

	public static function getInstance($config = array()){
		$id = json_encode($config);
		if( ! self::$instance[$id] ) {
			self::$instance[$id] = new DB($config);
		}
		return self::$instance[$id];
	}

	private  function __construct($config = array()){
		if(empty($config)) {
			$config = BackServer::getConfigItem('db');
			$this->_connnection = mysql_connect($config['server'],$config['user'],$config['password']);
			if(!is_resource($this->_connnection)) {
				BackServer::addLog('error', '用户名或密码错误@@@！');
			}
			if(isset($config['dbname'])) {
				mysql_select_db($config['dbname'],$this->_connnection);
			}
		}
	}

	/**
	 * 通过ID获得一条记录
	 * @param string $tbName 表明
	 * @param int $id 主键ID
	 */
	public function getItemById($tbName,$id = -1){
		return $this->getItem($tbName,'id = '.$id);
	}


	/**
	 * 获得符合条件的元素
	 * @param string $tbName 表明
	 * @param string $where where 条件
	 */
	public function getItems($tbName,$where = '',$limit=0 , $offset = 0 ){
		$sql = 'select * from ' . $tbName;
		if ($where) {
			$sql.=' where '.$where;
		}
		$result = $this->_query($sql);
		$items = array();
		while($r = mysql_fetch_array($result)) {
			$items[] = $r;
		}
		return $items;
	}

	/**
	 * 获得符合条件的一条记录
	 * @param string $tbName 数据表
	 * @param string $where where条件
	 */
	public function getItem($tbName,$where=''){
		if($items = $this->getItems($tbName,$where,0,1))
			return $items[0];

	}

	/**
	 * 更新数据
	 * @param string $tbName 表明
	 * @param array $opts 更新选项
	 * @param string $where 更新条件
	 */
	public function Update($tbName,$opts=array(),$where = '' ){
		if(empty($opts)) {
			BackServer::addLog('error', '传递参数出错啦！');
			return false;
		} else {
			$sql = 'update ' .$tbName . ' set ' ;
			foreach ($opts as $k=>$v) {
				$sql .= $k . ' = \''.$v.'\'';
			}
			if($where!='') {
				$sql .= ' where '.$where;
			}
			return $this->_query($sql);
		}
	}

	/**
	 * 删除数据
	 * @param string $tbName 表名
	 * @param string $where where条件
	 */
	public function delete($tbName,$where='') {
		$sql = 'delete from '.$tbName ;
		if($where){
			$sql .= ' where ' . $where;
		}
		return $this->_query($sql);
	}

	/**
	 * 添加元素
	 * @param string $tableName 表名
	 * @param array $opts 各个项的值
	 */
	public function addItme($tableName,$opts) {
		$sql = 'insert into ' . $tableName .' set ';
		foreach ($opts as $k=>$v ) {
			$sql .= $k . ' = \'' .$v . '\' , ';
		}
		$sql = trim($sql,', ');
		return $this->_query($sql);
	}

	public function _query($sql) {
		if ($r = mysql_query($sql,$this->_connnection) ) {
			return $r;
		} else {
			BackServer::addLog('error', mysql_error($this->_connnection).$sql);
			return false;
		}
	}

	public function __destruct() {
		mysql_close($this->_connnection);
	}

}
