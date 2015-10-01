<?php
#docker API 
set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__)."/phpseclib".PATH_SEPARATOR.dirname(__FILE__));

require_once("Net/SSH2.php");
require_once("Crypt/RSA.php");
require_once("utilities.php");

function ssh_connect($host)
{

	dbg_log("Connecting over SSH to $host");
	#define('NET_SSH2_LOGGING', NET_SSH2_LOG_COMPLEX);

	$ssh = new Net_SSH2($host);
	$key = new Crypt_RSA();
	$key->setPassword(get_config()->host_ssh_private_key_password);
	$keyPath = get_config()->host_ssh_private_key;
	$keyString = file_get_contents($keyPath);
	$userString = get_config()->host_ssh_username;

	if(!$key->loadKey($keyString)){
		dbg_log(var_dump($ssh->getErrors(),true));
		exit("cannot import key $keyPath");

	}
	
	if (!$ssh->login($userString,$key)) {
		dbg_log($ssh->getLastError());
	    exit('Login Failed');
	}

	return $ssh;
}

function ssh_exec($conn, $cmd)
{
	dbg_log($cmd);
	return $ssh->exec($cmd);	
}

