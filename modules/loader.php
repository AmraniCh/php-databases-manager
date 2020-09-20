<?php

$host = "localhost";
$user = "root";
$pass = "";

/** Auto-loading function */
function load ($directoryPath)
{
	$dir = opendir ($directoryPath);

	while (($item = readdir($dir)) !== false)
		if ( strpos ($item, ".php") )
			include_once "$directoryPath/$item";
}

load (dirname(__DIR__) . "/modules/utilities");
load (dirname(__DIR__) . "/modules/models");

$manager = new Manager ($host, $user, $pass);
