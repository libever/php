<?php

class SaeMysqlUtil {

	private $pdo;

	public function __construct(){
		$dsn = "mysql:host=" . SAE_MYSQL_HOST_M . ";port=" . SAE_MYSQL_PORT . ";dbname=" . SAE_MYSQL_DB;
		$this->pdo = new PDO($dsn,SAE_MYSQL_USER,SAE_MYSQL_PASS);
	}

	public function run_sql($sql,$params = array(),$sql_type = Mysql::SELECT){
		switch($sql_type){
			case Mysql::SELECT:
				return $this->read($sql,$params);
			case Mysql::INSERT:
				return $this->create($sql,$params);
			case Mysql::UPDATE:
				return $this->update($sql,$params);
			case Mysql::DELETE:
				return $this->delete($sql,$params);
		}
	}

	public function create($sql,$params){
		$stmt = $this->pdo->prepare($sql);	
		foreach($params as $param_name=>$param_value){
			$stmt->bindValue($param_name,$param_value);
		}
		if($stmt->execute()){
			return $this->pdo->lastInsertId();	
		} else {
			return false;		
		}
	}

	public function read($sql,$params){
		$stmt = $this->pdo->prepare($sql);	
		foreach($params as $param_name=>$param_value){
			$stmt->bindValue($param_name,$param_value);
		}
		if($stmt->execute()){
			return $stmt->fetchAll();
		} else {
			return false;		
		}
	}

	public function update($sql,$params){
		$stmt = $this->pdo->prepare($sql);	
		foreach($params as $param_name=>$param_value){
			$stmt->bindValue($param_name,$param_value);
		}
		if($stmt->execute()){
			return $stmt->rowCount();
		} else {
			return false;		
		}
	}

	public function delete($sql,$params){
		$stmt = $this->pdo->prepare($sql);	
		foreach($params as $param_name=>$param_value){
			$stmt->bindValue($param_name,$param_value);
		}
		if($stmt->execute()){
			return $stmt->rowCount();
		} else {
			return false;		
		}
	}

}
