<?php

require_once(dirname(__FILE__)."/../lib/utilities.php");
require_once(dirname(__FILE__)."/../lib/marathon_api.php");
require_once(dirname(__FILE__)."/../lib/docker_api.php");

$apps=marathon_get_apps();
#var_dump($apps);

?>
<div class="panel panel-default">
<div class="panel-heading">Apps</div>
<table class="table">
<thead>
<tr>
	<th>Id</th>
	<th>Operation</th>
</tr>
</thead>
<tbody>
<?php 
if(count($apps)==0)
	echo "<tr scope=\"row\"><td>No applications</td><tr>";
else
foreach($apps as $app){ 

	$appid=$app["id"];

	$prefix=substr($appid,1,strlen(get_config()->app_prefix));
	if($prefix == get_config()->app_prefix)
	{
		$appid=substr($appid,strlen(get_config()->app_prefix)+2);	
		echo "<tr scope=\"row\"><td><a href=\"/app_details.php?appid=$appid\">$appid</a></td>
<td><button type=\"button\" class=\"btn btn-danger\" onClick=\"destroy_app('$appid');\">Destroy</button>
</td></tr>";
	}
} 
?>
</tbody>
</table>
</div>

<script type="text/javascript">
function destroy_app(appid)	
{
	$.post("destroy_app.php","appid="+appid);	
	
}
</script>


