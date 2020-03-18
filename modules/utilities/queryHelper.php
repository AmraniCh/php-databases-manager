<?php

class QueryHelper
{
    public const SHOW_DATABASES = "SHOW DATABASES";

    public static function get_tables ($database)
    {
        return "select TABLE_NAME from information_schema.tables where table_schema='$database'";
    }

    public static function get_columns ($table, $database)
    {
        return "select COLUMN_NAME, COLUMN_TYPE, COLUMN_DEFAULT, IS_NULLABLE, EXTRA, COLUMN_KEY 
        from information_schema.columns where table_name = '$table' and table_schema = '$database'";
    }

    public static function get_fk_details ($column, $table, $database)
    {
        return "SELECT REFERENCED_TABLE_NAME as REF_TABLE, REFERENCED_COLUMN_NAME as REF_COLUMN FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA='$database' AND TABLE_NAME='$table' AND COLUMN_NAME='$column'";
    }

    public static function get_rows ($table)
    {
        return "select * from $table";
    }

    public static function get_table_size ($table, $database)
    {
        return "select ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024) AS `SIZE`
        from information_schema.tables where table_name = '$table' and table_schema='$database'";
    }

    public static function create_user ($username, $password)
    {
        return "CREATE USER '$username'@'localhost' IDENTIFIED BY '$password'";
    }

    public static function drop_user ($username)
    {
        return "DROP USER '$username'@'localhost'";
    }

    public static function grant_permission ($user, $privilege, $table, $database)
    {
        return "GRANT $privilege ON $database.$table TO '$user'@'localhost'";
    }

    public static function revoke_permission ($user, $privilege, $table, $database)
    {
        return "REVOKE $privilege ON $database.$table FROM '$user'@'localhost'";
    }

    public static function exec_query ($query, $connection, $fetch_mode = "assoc")
    {
        $data = [];

        $result = $connection->query($query);

        if (!$result)
            throw new Exception ("An error occurred when trying to execute: $query");

        while ($row = ( $fetch_mode == "assoc" ) ? $result->fetch_assoc() : $result->fetch_row())
            array_push($data, $row);
            
        return $data;
    }

    public static function get_permissions($user)
    {
        return "SHOW GRANTS FOR '$user'@'localhost';";
    }
}
