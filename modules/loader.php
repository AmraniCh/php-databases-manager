<?php

$root = $_SERVER["DOCUMENT_ROOT"] . "/DatabasesManager";

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

load ("$root/modules/utilities");
load ("$root/modules/models");

$manager = new Manager ($host, $user, $pass);
