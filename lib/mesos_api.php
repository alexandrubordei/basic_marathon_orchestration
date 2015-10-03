<?php
#MESOS api

include_once("utilities.php");


function mesos_get_state()
{

	$ch  = curl_init();
	$url =  get_config()->mesos_uri."/state.json";

	dbg_log("Calling ".$url);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch);


	dbg_log($result);
	curl_close($ch);
	$decoded_object=json_decode($result,true);	
	return $decoded_object;
}


?>
