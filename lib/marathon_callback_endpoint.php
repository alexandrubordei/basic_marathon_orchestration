<?php


include_once("utilities.php");
include_once("app.php");

//get body
$entityBody = file_get_contents('php://input');

handle_event($entityBody);




