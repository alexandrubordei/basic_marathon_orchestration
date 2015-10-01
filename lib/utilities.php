<?php
require("config.php");

function dbg_log($msg)
{
	$now = new DateTime(null,new DateTimeZone('America/New_York'));
	$str = $now->format('Y-m-d H:i:s') . "   " . $msg."\n"; 
	echo $str;
	file_put_contents(LOG_FILE,$str,FILE_APPEND);
}

function get_config()
{
	$config_json=file_get_contents(CONFIG_FILE);
	return json_decode($config_json);
}

