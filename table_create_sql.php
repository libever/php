<?php

$host = '';
$port = 3362;
$db = '';
$user = '';
$pwd = '';

$pdoString = sprintf("mysql:host=%s;port=%d;dbname=%s",$host,$port,$db);
$pdo = new PDO($pdoString,$user,$pwd);

$tables = $pdo->query("show tables;")->fetchAll();

foreach($tables as $table){
	$sql = "show create table ${table[0]};\n";
	$r = $pdo->query($sql)->fetchAll();
	$create_sql = $r[0][1] . ";\n";
	$reg = '/AUTO_INCREMENT=\d+/';
	$create_sql = preg_replace($reg,'',$create_sql);
	echo $create_sql . "\n";
}
