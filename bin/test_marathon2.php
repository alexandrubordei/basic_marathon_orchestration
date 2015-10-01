<?php 
require_once(dirname(__FILE__)."/../lib/marathon_api.php");
require_once(dirname(__FILE__)."/../lib/mesos_api.php");

 
$task=marathon_get_tasks("test");

#var_dump($task[0]->host);

#var_dump($task[0]->id);

$mesos_state= mesos_get_state();

var_dump($mesos_state);
#var_dump($mesos_state->frameworks[0]->tasks[0])

?>
