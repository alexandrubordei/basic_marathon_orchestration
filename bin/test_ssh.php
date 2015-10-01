<?php
include_once(dirname(__FILE__) ."/../lib/docker_api.php");
include_once(dirname(__FILE__) ."/../lib/utilities.php");

$ssh = ssh_connect("instance-11842.bigstep.io");

dbg_log($ssh->exec("ls /"));


?>
