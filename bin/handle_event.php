<?php

include_once(dirname(__FILE__) ."/../bin/events.php");
include_once(dirname(__FILE__) ."/../lib/utilities.php");



$post=file_get_contents("php://input");

handle_event($post);


