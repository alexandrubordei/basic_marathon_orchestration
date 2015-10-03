<?php

require_once(dirname(__FILE__)."/../lib/marathon_api.php");
require_once(dirname(__FILE__)."/../lib/mesos_api.php");

$state=mesos_get_state();
var_dump($state);
