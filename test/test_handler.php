<?php

include_once(dirname(__FILE__) ."/../lib/utilities.php");
include_once(dirname(__FILE__) ."/../lib/app.php");


$fixture = file_get_contents("test_status.json");

handle_event($fixture);
