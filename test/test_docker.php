<?php
include_once(dirname(__FILE__) ."/../lib/docker_api.php");
include_once(dirname(__FILE__) ."/../lib/utilities.php");



$containers=docker_get_containers("instance-11842.bigstep.io");

$containerID=$containers[1]["Id"];
$containerDetails=docker_get_container_details("instance-11842.bigstep.io", $containerID);
var_dump($containerDetails); 

foreach($containerDetails["Config"]["Env"] as $env)
{
	if(substr($env, 0, strlen("MESOS_TASK_ID"))=="MESOS_TASK_ID")
	{
		$mesos_task_id = substr($env, strlen("MESOS_TASK_ID")+1);
		break;
	}
};

var_dump($mesos_task_id);

#docker_add_container_public_ip("instance-11703.bigstep.io", $containerID, "84.40.61.35",27,"84.40.61.33")

?>
