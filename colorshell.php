<?php
#define test_cond(_c) if(_c) printf("\033[0;32mPASSED\033[0;0m\n"); else {printf("\033[0;31mFAILED\033[0;0m\n"); fails++;}

function color_echo($message,$res){
	if($res){
		printf("\033[0;32m%s\033[0;0m\n",$message); 
	} else {
		printf("\033[0;31m%s\033[0;0m\n",$message);
	}
}

color_echo("OK message ...",true);
color_echo("FAIL message ...",false);
