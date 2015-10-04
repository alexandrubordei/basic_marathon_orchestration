<?php

require_once(dirname(__FILE__)."/../lib/utilities.php");
require_once(dirname(__FILE__)."/../lib/marathon_api.php");
require_once(dirname(__FILE__)."/../lib/docker_api.php");
require_once(dirname(__FILE__)."/../lib/ippool.php");


if(!array_key_exists("containerid",$_GET) || !array_key_exists("host",$_GET))
{
	echo "missing containerid or missing container_host";
}

$taskID=$_GET["containerid"];
$host=$_GET['host'];

#$container_details=docker_get_container_details_for_all($host);
#$container=$container_details[$id];
#if($container==null)
#	echo "Contaier with mesos  $id not found on host $host";

$state=ip_pool_get_state();
#var_dump($state);
$publicIP="none";
$containerID="none";
foreach($state["meta"] as $ip=>$metadata)
{
	if($metadata["taskID"]==$taskID)
	{
		$containerID=$metadata["containerID"];
		$publicIP=$ip;
		break;
	}
}

#var_dump($container_details);
?>
<div class="panel panel-default">
<div class="panel-heading">Container Details</div>
<ul class="list-group">

	<li class="list-group-item">Mesos ID: <?php echo $taskID; ?></li>
	<li class="list-group-item">Docker ID: <?php echo $containerID; ?></li>
	<li class="list-group-item">Host: <?php echo $host; ?></li>
	<li class="list-group-item">Public IP: <?php echo $publicIP; ?></li>
		

</tbody>
</table>
</div>

