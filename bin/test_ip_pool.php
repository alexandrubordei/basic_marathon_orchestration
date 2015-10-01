<?php
include_once(dirname(__FILE__) ."/../lib/ippool.php");
include_once(dirname(__FILE__) ."/../lib/utilities.php");

var_dump(ip_pool_get_state());

$ip1 = ip_pool_allocate("ip1");
$ip2 = ip_pool_allocate("ip2");
var_dump($ip1);
var_dump($ip2);
$meta2 = ip_pool_deallocate($ip2);
$meta1 = ip_pool_deallocate($ip1);

var_dump(ip_pool_get_state());

