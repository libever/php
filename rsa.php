<?php

function rsa_encrypt($pri,$message){
	$encrypted = "";
	$pi_key =  openssl_pkey_get_private($pri);
	openssl_private_encrypt($message,$encrypted,$pi_key);
	return base64_encode($encrypted);
}

function rsa_decrypt($pub,$message){
	$decrypt_message = "";
	$pu_key = openssl_pkey_get_public($pub);
	openssl_public_decrypt(base64_decode($message),$decrypt_message,$pu_key);
	return $decrypt_message;
}

