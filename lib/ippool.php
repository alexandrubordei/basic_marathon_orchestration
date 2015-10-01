<?php
#basic IP management

include_once("utilities.php");


function ip_pool_get_state()
{
	$state_file = get_config()->ip_pool_state_file;

	if(!file_exists($state_file))
	{
		$available_ips= get_config()->ip_pool;	
		$state=Array(	
			"available_ips" => $available_ips,
			"used_ips" => Array(),
			"meta" => Array()	
		);
		ip_pool_save_state($state);
	}
	return json_decode(file_get_contents($state_file),true);	
}

function ip_pool_save_state($state)
{
	$state_file = get_config()->ip_pool_state_file;

	file_put_contents($state_file,json_encode($state));
}


//new IP address is allocated and locked (one that is not currently in use) and metadata is associated in the state json with that particular IP address
function ip_pool_allocate($metadata)
{
	$state = ip_pool_get_state();

	$available_ips = $state["available_ips"];
	$used_ips = $state["used_ips"];
	$meta = $state["meta"];
	
	if(count($available_ips)==0)
		throw new Exception("IP Pool ran out of IP Addresses");	

	$ip = array_shift($available_ips);	
	$meta[$ip] = $metadata;	
	
	array_push($used_ips, $ip);

	$state["available_ips"] = $available_ips;
	$state["used_ips"] = $used_ips;
	$state["meta"] = $meta;

	ip_pool_save_state($state);

	return $ip;
	
}

function ip_pool_deallocate($ip)
{
	$state = ip_pool_get_state();

	$available_ips = $state["available_ips"];
	$used_ips = $state["used_ips"];
	$meta = $state["meta"];
	$old_meta=$meta[$ip];

	$used_ips = array_diff($used_ips,array($ip));	
	
	array_push($available_ips, $ip);
	unset($meta[$ip]);	

	$state["available_ips"] = $available_ips;
	$state["used_ips"] = $used_ips;
	$state["meta"] = $meta;

	ip_pool_save_state($state);

	return $old_meta;

}
