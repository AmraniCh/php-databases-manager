<?php

include "../modules/loader.php";

echo json_encode ($manager->getDatabase("testdatabase")->fetchTablesJSON ());