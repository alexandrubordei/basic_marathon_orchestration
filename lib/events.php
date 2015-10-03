<?php

#app controller 

include_once("utilities.php");

function handle_event($event_json)
{

	$event = json_decode($event_json, true);

	if($event["eventType"] == "status_update_event")) 		
		return handle_status_update_event($event);
}


function handle_status_update_event($event)
{

	    if( substr($event["appId"],0,3) == get_config()->app_prefix  //is it ours?
	    && $event["taskStatus"] == "TASK_RUNNING"  			//has the proper status?
	){
		$taskId = $event["taskId"];
		//then we need to add the pipework	
		//to do that we need to identify the container
		//we have the marathon id but we need the docker id
		$host = $event["host"];
		$containers = docker_get_containers($event[$host]);
		//now we need to get the containers from our applications
		foreach($containers as $container)
		{
			$container_details=docker_get_container_details($host, $container["id"])
			$containerID = $container_details["Id"];

			foreach($containerDetails["Config"]["Env"] as $env)
				if($env == "MESOS_TASK_ID=$taskId")
				{
					//this is our ip
					$ip=ip_pool_allocate(array(
						"taskID":"$taskId", 
						"host":$host));	
					docker_add_container_public_ip($host, $containerID, $ip, get_conf()->ip_pool_netmask, get_conf()->ip_pool_gateway);
				}

		};
					
		}
		
	}


 	
}	



}


