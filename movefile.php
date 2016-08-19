<?php

$listfile = "pylist.txt";

$lines = file($listfile);
mkdir("output");
foreach($lines as $file){
	$file = trim($file);
	$dir = dirname($file);
	$dir = ltrim($dir,".");
	$todir = "./output" . $dir ;

	echo "check dir $todir \n";
	if(!is_dir($todir)){
		system( "mkdir -p $todir ");
	}

	echo "read file :  $file \n";
	$contents = file_get_contents($file);

	$realfilename = basename($file);
	echo "write to : $todir/$realfilename\n";
	file_put_contents($todir . '/'. $realfilename , $contents);


}
