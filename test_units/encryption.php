<?php

include "../modules/loader.php";

$encryptionQuery = $manager->connection->query ("SELECT PASSWORD ('123')");
$encryptedPassword = $encryptionQuery->fetch_row ()[0];

echo $encryptedPassword;