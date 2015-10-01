<?php
#MARATHON api

include_once("utilities.php");

function marathon_create($app_id)
{
	$app_id_sanitised=preg_replace("/[^A-Za-z0-9 ]/", '', $app_id);
	$app_definition = array(
		"id"   => "cb-".$app_id_sanitised,
		"cpus" => 0.5,
		"mem"  => 1000,
		"instances" => 3,
		"container" =>
		    array(
			"type" => "DOCKER",
			"docker" => 
			    array(
				"image" => "couchbase/server",
				"network" => "BRIDGE"
			   )
		    )
	    );

	$app_definition_json=json_encode($app_definition);

	$ch  = curl_init();
	$url = get_config()->marathon_uri."/v2/apps";

	dbg_log("Calling ".$url);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($app_definition_json)));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $app_definition_json);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch);


	dbg_log($result);

	curl_close($ch);

	return $app_id_sanitised;
}


function marathon_get_tasks($app_id)
{
	$app_id_sanitised=preg_replace("/[^A-Za-z0-9 ]/", '', $app_id);

	$ch  = curl_init();
	$url = get_config()->marathon_uri."/v2/apps/cb-".$app_id_sanitised."/tasks";

	dbg_log("Calling ".$url);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch);


	dbg_log($result);
	curl_close($ch);
	$decoded_object=json_decode($result);	
	return $decoded_object->tasks;
}

