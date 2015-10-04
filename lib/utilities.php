<?php
require("config.php");

function dbg_log($msg)
{
	$now = new DateTime(null,new DateTimeZone('America/New_York'));
	$str = $now->format('Y-m-d H:i:s') . "   " . $msg."\n"; 
#	echo $str;
	file_put_contents(get_config()->log_file,$str,FILE_APPEND);
}

function get_config()
{
	$config_json=file_get_contents(CONFIG_FILE);

	$decoded=json_decode($config_json);
	if($decoded==NULL)
		throw new Exception("Could not read config file ".CONFIG_FILE);

	return $decoded;
}

