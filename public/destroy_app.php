<?php
require_once(dirname(__FILE__)."/../lib/utilities.php");
require_once(dirname(__FILE__)."/../lib/marathon_api.php");
var_dump($_POST);
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(array_key_exists("appid",$_POST))
	{
		$appid=strtolower($_POST["appid"]);
		$appid = str_replace(' ', '', $appid);
		if(strlen($appid>100))
			$appid=substr($appid,0,100);
		dbg_log("destroying app $appid");
		marathon_destroy($appid);
	}
}

