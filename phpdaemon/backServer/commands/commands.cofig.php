<?php

	return array(
		'everySleepSeconds'=>2,
		'db' =>array('server'=>'localhost','user'=>'qxy','password'=>'TmQxy1987','dbname'=>'qxy_zhidaodemo'),
		'commandTableName'=>'cms_command',
		'clearFrequency'=>10,
		'CommandParser'=>'Parser',
		'params'=>array(
			'ffmpeg'=>'/usr/bin/ffmpeg',
			'flvtool2'=>'/usr/bin/flvtool2',
			'flv_log_path'=>'/dev/shm/'
		)
	);
