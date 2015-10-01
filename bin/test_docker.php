<?php
include_once(dirname(__FILE__) ."/../lib/docker_api.php");
include_once(dirname(__FILE__) ."/../lib/utilities.php");

$containers=docker_get_containers("instance-11703.bigstep.io");
$containerID=$containers[0]->Id;
$containerDetails=docker_get_container_details("instance-11703.bigstep.io", $containerID);
var_dump($containerDetails); 

#docker_add_container_public_ip("instance-11703.bigstep.io", $containerID, "84.40.61.35",27,"84.40.61.33")

?>
