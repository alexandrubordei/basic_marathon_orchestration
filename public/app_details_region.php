<?php

require_once(dirname(__FILE__)."/../lib/utilities.php");
require_once(dirname(__FILE__)."/../lib/marathon_api.php");
require_once(dirname(__FILE__)."/../lib/docker_api.php");


if(!array_key_exists("appid",$_GET))
	echo "missing appid";

$tasks=marathon_get_tasks($_GET['appid']); 

#var_dump($tasks);

?>
<div class="panel panel-default">
<div class="panel-heading">Tasks</div>
<table class="table">
<thead>
<tr>
	<th>Id</th>
</tr>
</thead>
<tbody>
<?php 
if(count($tasks)==0)
	echo "<tr scope=\"row\"><td>please wait...</td><tr>";
else
foreach($tasks as $task){ 

	$id=$task["id"];
	$host=trim($task["host"]);

	echo "<tr scope=\"row\"><td><a href=\"/container_details.php?containerid=$id&host=$host\">$id</a></td></tr>";
} 
?>
</tbody>
</table>
</div>

