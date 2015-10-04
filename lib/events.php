<?php

#app controller 

require_once(dirname(__FILE__)."/utilities.php");
require_once(dirname(__FILE__)."/marathon_api.php");
require_once(dirname(__FILE__)."/docker_api.php");
require_once(dirname(__FILE__)."/ippool.php");



function handle_event($event_json)
{

	dbg_log($event_json);	
	$event = json_decode($event_json, true);


	if($event["eventType"] == "status_update_event")
		return handle_status_update_event($event);
}


function handle_status_update_event($event)
{

	     dbg_log("Received event ".print_r($event,true));
	     $prefix=substr($event["appId"],1,strlen(get_config()->app_prefix));
		dbg_log("prefix is $prefix");

	    if( $prefix == get_config()->app_prefix  && $event["taskStatus"] == "TASK_RUNNING"){
	   	dbg_log("Handling event");

		$taskId = $event["taskId"];
		//then we need to add the pipework	
		//to do that we need to identify the container
		//we have the marathon id but we need the docker id
		$host = $event["host"];
		$containers_details = docker_get_container_details_for_all($host);
		$container = $containers_details[$taskId];
		$containerID = $container["Id"];

		$ip=ip_pool_allocate(array(
				"taskID"=>"$taskId", 
				"containerID"=>"$containerID", 
				"host"=>$host));	

		if($ip==NULL)
			throw new Exception("Could not allocate an ip address!");

		dbg_log("Allocating ip $ip to docker id $containerID and mesos id $taskId");
		docker_add_container_public_ip($host, $containerID, $ip, get_config()->ip_pool_netmask, get_config()->ip_pool_gateway);
	}

	  if( $prefix == get_config()->app_prefix  && $event["taskStatus"] == "TASK_KILLED"){
	   	dbg_log("Handling event");

		$taskID = $event["taskId"];

		$state=ip_pool_get_state();
		#var_dump($state);
		$publicIP="none";
		$containerID="none";
		foreach($state["meta"] as $ip=>$metadata)
		{
			if($metadata["taskID"]==$taskID)
			{
				$containerID=$metadata["containerID"];
				$publicIP=$ip;
				break;
			}
		}

		if($publicIP!="none")
		{
			dbg_log("Deallocating ip $publicIP from $taskID");
			ip_pool_deallocate($publicIP);
		}
		else
		{
			dbg_log("Could not find allocated ip for container $taskID");
		}
	}



}


