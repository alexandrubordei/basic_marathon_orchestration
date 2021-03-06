<?php
#DOCKER api 
require_once("ssh.php");



function docker_get_containers($host)
{
	$cmd = "curl -s --unix-socket /var/run/docker.sock http:/containers/json";			
	dbg_log("docker_get_containers: $cmd");
	
	$ssh = ssh_connect($host);
	$json=$ssh->exec($cmd);
	dbg_log($json);
	return json_decode($json,true);
}

function docker_get_container_details($host, $containerID)
{
	$cmd = "curl -s --unix-socket /var/run/docker.sock http:/containers/$containerID/json";			

	dbg_log("docker_get_container_details: $cmd");

	$ssh = ssh_connect($host);
	$json=$ssh->exec($cmd);
	dbg_log($json);
	return json_decode($json,true);
}

function docker_add_container_public_ip($host, $containerID, $ip)
{
	$pipework = get_config()->pipework_path;
	$bridge = get_config()->wanbridge;

	$cmd = "$pipework $bridge $containerID $ip";
	dbg_log("get_container_details: $cmd");

	$ssh = ssh_connect($host);
	$json=$ssh->exec($cmd);
	dbg_log($json);
}

function docker_get_container_details_for_all($host)
{

	$containers = docker_get_containers($host);
	$container_details =array();

	foreach($containers as $container)
	{

	#	var_dump($container);

		$containerID = $container["Id"];
		$containerDetails=docker_get_container_details($host, $containerID);

		foreach($containerDetails["Config"]["Env"] as $env)
		{
			if(1==preg_match('/^MESOS_TASK_ID\=(.*)/',$env,$match)) 
			{
				dbg_log("===========Found match {$match[1]}".print_r($match,true)." in ".$env);
				$container_details[$match[1]]=$containerDetails;
			}	
		}
	}	
	return $container_details;
}
