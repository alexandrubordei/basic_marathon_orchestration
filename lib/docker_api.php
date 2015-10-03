<?php
#DOCKER api 
require_once("ssh.php");



function docker_get_containers($host)
{
	$cmd = "echo -e \"GET /containers/json HTTP/1.0\r\n\" | nc -U /var/run/docker.sock | tail -n +6";			

	$ssh = ssh_connect($host);
	$json=$ssh->exec($cmd);
	dbg_log($json);
	return json_decode($json,true);
}

function docker_get_container_details($host, $containerID)
{
	$cmd = "echo -e \"GET /containers/$containerID/json HTTP/1.0\r\n\" | nc -U /var/run/docker.sock | tail -n +5";			

	dbg_log("get_container_details: $cmd");

	$ssh = ssh_connect($host);
	$json=$ssh->exec($cmd);
	dbg_log($json);
	return json_decode($json,true);
}

function docker_add_container_public_ip($host, $containerID, $ip, $netmask, $gateway)
{
	$pipework = get_config()->pipework_path;
	$bridge = get_config()->wanbridge;

	$cmd = "$pipework $bridge $containerID $ip/$netmask@$gateway";
	dbg_log("get_container_details: $cmd");

	$ssh = ssh_connect($host);
	$json=$ssh->exec($cmd);
	dbg_log($json);
}
