<?php
#DOCKER api 
require_once("ssh.php");



function get_container_details($host,$containerId)
{
	$ssh = ssh_connect($host);
	$json=$ssh->exec("echo -e "GET /images/json HTTP/1.0\r\n" | nc -U /var/run/docker.sock | tail -n +6");			
}
