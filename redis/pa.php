<?php

$host = "localhost";
$port = 6379;
$key = "testkey";
$val = "ok";

$redis = new Redis();
$redis->connect($host,$port);
$redis->set($key,$val);
echo $redis->get($key);
$redis->close();
