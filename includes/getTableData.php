<?php


try{ $pdo = new PDO('mysql:host=localhost;dbname=' . $_POST['database'], "root", ""); }
catch( Exception $ex ) { echo $ex->getMessage(); }

$query = $pdo->prepare(" SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA=:database
AND TABLE_NAME=:table ");

$query->execute(array(":database" => $_POST['database'], ':table' => $_POST['table']));
while( $row = $query->fetch( PDO::FETCH_BOTH ) ){
  $columns[] = ['title' => $row[0]];
}

$query = $pdo->query(" SELECT * FROM personnage ");
while( $row = $query->fetch( PDO::FETCH_BOTH ) ){
  $data[] = [$row[0], $row[1], $row[2]];
}

echo json_encode(array('data' => $data, 'columns' => $columns));
