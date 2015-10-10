<?php 
require_once(dirname(__FILE__)."/../lib/marathon_api.php");
require_once(dirname(__FILE__)."/../lib/mesos_api.php");

 
$task=marathon_get_apps("test");

#var_dump($task[0]->host);

var_dump($task);


?>
