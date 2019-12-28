<?php

include "../modules/loader.php";

$username = "jotaro";
$password = "";

// UserManager::createUser ($username, $password, $manager->connection);
UserManager::grantPermission ($username, "ALL PRIVILEGES", "*", "*", $manager->connection);

foreach ($manager->getDatabaseNames() as $name) 
    echo "$name <br>";