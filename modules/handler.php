<?php

include "loader.php";

try
{
    if (!isset ($_POST["type"]))
        throw new Exception("No type given!");

    $type = $_POST['type'];

    switch ($type)
    {
        case "status":
            if ($manager->connection == null)
                throw new Exception("");
            break;

        case "signIn":
            echo (UserManager::signIn ($_POST["user"], $_POST["pass"], $manager->connection));
            break;

        case "signIn":
            UserManager::signOut ();
            break;

        case "databases":
            echo json_encode ($manager->fetchDatabasesJSON());
            break;

        case "tables":
            echo json_encode ($manager->getDatabase ($_POST["database"])->tables);
            break;

        case "table":
            echo json_encode ($manager->getTable($_POST["database"], $_POST["table"]));
            break;

        case "insert":
            $manager->getTable ($_POST["database"], $_POST ["table"])->add ($_POST);
            break;

        case "delete":
            // move the pointer to the end of the array
            end($_POST);
            // fetches the key of the element pointed to by the pointer
            $idKey = key($_POST);

            $manager->getTable ($_POST["database"], $_POST ["table"])->remove ([$idKey => $_POST[$idKey]]);
        break;

        case "update":
            // move the pointer to the end of the array
            end($_POST);
            // fetches the key of the element pointed to by the pointer
            $idKey = key($_POST);

            $manager->getTable ($_POST["database"], $_POST ["table"])->update ([$idKey => $_POST[$idKey]], $_POST);
        break;
    }

}
catch (Exception $e)
{
    echo json_encode (["error" => $e->getMessage ()]);
}
