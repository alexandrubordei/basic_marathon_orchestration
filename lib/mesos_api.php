<?php
#MESOS api

include_once("utilities.php");

function get_mesos_service_url()
{
	return get_config()->mesos_uri;
}
function mesos_get_state()
{

	$ch  = curl_init();
	$url = get_mesos_service_url()."/state.json";

	dbg_log("Calling ".$url);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch);


	dbg_log($result);
	curl_close($ch);
	$decoded_object=json_decode($result);	
	return $decoded_object;
}


?>
