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

		$dockerimage=strtolower($_POST["dockerimage"]);	
		$instances=intval($_POST["instances"]);	
		$cpus=floatval($_POST["cpus"]);	
		$mem=intval($_POST["mem"]);	

		dbg_log("creating app $appid");
		marathon_create($appid,
				$dockerimage,
				$cpus,
				$mem,
				$instances);
		header("Location: http://".$_SERVER["SERVER_NAME"]."/app_details.php?appid=$appid");
	}
}

