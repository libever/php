<?php

$host = "localhost";
$port = 11211;
$timeout = 10;
$key = "testkey";
$val = "ok\n";

$mem = new Memcache();
$mem->connect($host,$port,$timeout);
$mem->set($key,$val);

echo $mem->get($key);
