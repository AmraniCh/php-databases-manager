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
        return "select COLUMN_NAME, DATA_TYPE, COLUMN_DEFAULT, IS_NULLABLE, EXTRA 
        from information_schema.columns where table_name = '$table' and table_schema = '$database'";
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
        while ($row = ( $fetch_mode == "assoc" ) ? $result->fetch_assoc() : $result->fetch_row())
            array_push($data, $row);
            
        return $data;
    }

    public static function get_permissions($user){
        return "SHOW GRANTS FOR '".$user."'@'localhost';";
    }
}
