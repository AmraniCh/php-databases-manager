<?php

/**
 * getcwd: gets the directory of the current executing file
 */
$root = getcwd();

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

load ($root . "/utilities");
load ($root . "/models");

$manager = new Manager ($host, $user, $pass);
