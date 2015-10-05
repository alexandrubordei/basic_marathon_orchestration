<?php 

include_once(dirname(__FILE__) ."/../lib/marathon_api.php");
include_once(dirname(__FILE__) ."/../lib/utilities.php");

$max=$argv[1];

for($i=1;$i<=$max;$i++) 
{
	marathon_create("test-$i","couchbase/server",0.5,1024,3);
}


?>
