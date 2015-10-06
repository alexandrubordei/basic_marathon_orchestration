<?php
#MARATHON api

include_once("utilities.php");

function marathon_create($app_id, $docker_image_name,$cpus,$mem,$instances)
{
	dbg_log("Marathon create for $app_id");
	$app_id_sanitised=preg_replace("/[^A-Za-z0-9 ]/", '', $app_id);
	$app_definition = array(
		"id"   => get_config()->app_prefix."-".$app_id_sanitised,
		"cpus" => $cpus,
		"mem"  => $mem,
		"instances" => $instances,
		"container" =>
		    array(
			"type" => "DOCKER",
			"docker" => 
			    array(
				"image" => $docker_image_name,
				"network" => "BRIDGE",
				"parameters" => array( 
							array( "key" => "ulimit", "value" => "nofile=40960:40960" ),
							array( "key" => "ulimit", "value" => "core=100000000:100000000" ),
							array( "key" => "ulimit", "value" => "memlock=100000000:100000000" )
						)
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

function marathon_destroy($app_id)
{
	dbg_log("Marathon destroy for $app_id");
	$app_id_sanitised=preg_replace("/[^A-Za-z0-9 ]/", '', $app_id);

	$ch  = curl_init();
	$url = get_config()->marathon_uri."/v2/apps/".get_config()->app_prefix."-".$app_id_sanitised;

	dbg_log("Calling ".$url);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch);


	dbg_log($result);

	curl_close($ch);

	return $result;
}




function marathon_get_tasks($app_id)
{
	$app_id_sanitised=preg_replace("/[^A-Za-z0-9 ]/", '', $app_id);

	$ch  = curl_init();
	$url = get_config()->marathon_uri."/v2/apps/".get_config()->app_prefix."-".$app_id_sanitised."/tasks";

	dbg_log("Calling ".$url);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch);

	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	if($httpCode != 200)
		return NULL;


	
	dbg_log($result);
	curl_close($ch);
	$decoded_object=json_decode($result,true);	
	return $decoded_object["tasks"];
}

