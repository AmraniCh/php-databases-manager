<?php

class UserManager
{
    /**
     * add a new user;
     * PS: When mysql creates a new user, it encrypts the password,
     * and there is no easy way to decrypt it since we don't know how the encryption works,
     * so after creating the user, we should update the password to a normal string
     */
    public static function createUser ($username, $password, $connection)
    {
        if (!$connection->query (QueryHelper::create_user($username, $password)))
            throw new Exception("User could not be created");
    }

    /**
     * drop existing user
     */
    public static function dropUser ($username, $connection)
    {
        return $connection->query (QueryHelper::drop_user ($username));
    }

    /**
     * Get all users
     */
    public static function getUsers ($connection) : array
    {
        return (new Table("user", "mysql", $connection))->rows;
    }

    /**
     * Get one user
     */
    public static function getUser ($username, $connection)
    {
        foreach (self::getUsers($connection) as $user)
            if (strcmp ($username, $user["User"]) == 0)
                return $user;

        return null;
    }

    /**
     * Get user names
     */
    public static function getUserNames ($connection) : array
    {
        $names = [];

        foreach (self::getUsers ($connection) as $row)
            $names[] = ["name" => $row["User"], "host" => $row['Host']];

        return $names;
    }

    /**
     * Grant permission
     */
    public static function grantPermission ($user, $privilege, $table, $database, $connection) : bool
    {
        return $connection->query(QueryHelper::grant_permission($user, $privilege, $table, $database));
    }

    /**
     * Revoke permission
     */
    public static function revokePermission ($user, $privilege, $table, $database, $connection) : bool
    {
        return $connection->query(QueryHelper::revoke_permission($user, $privilege, $table, $database));
    }

    /**
     * Sign in
     */
    public static function signIn ($username, $password, $connection)
    {
        $user = self::getUser ($username, $connection);

        if ($user == null)
          throw new Exception ("Connection to database has failed");

        /** retrieving and checking password */
        if( isset($user['Password']) ){

          $encryptionQuery = $connection->query ("SELECT PASSWORD ('$password')");
          $encryptedPassword = $encryptionQuery->fetch_row ()[0];

          if (strcmp ($user["Password"], $encryptedPassword) != 0)
              throw new Exception ("Connection to database has failed");
        }

        session_start ();

        $_SESSION["user"] = $username;
        $_SESSION["pass"] = $password;

        return true;
    }

    // Sign out
    public static function signOut () 
    {
        session_start ();
        session_destroy ();
    }

    // Checks if there's an open session  
    public static function checkIfConnected()
    {
        session_start ();
      
        return isset ($_SESSION["user"]);
    }

    // Get user permissions
    public static function getUserPermissions($user, $connection)
    {
        $query = QueryHelper::get_permissions($user);

        if(!QueryHelper::exec_query($query, $connection, "row"))
            throw new Exception("Get User Permissions Failed.");

        $grant_string = QueryHelper::exec_query($query, $connection, "row")[0][0];

        if( strpos($grant_string, 'ALL PRIVILEGES') )
        {
            $data["SELECT"] = $data["INSERT"] = $data["UPDATE"] = $data["DELETE"] = "Yes";
            
            return array($data);
        }

        $permissions = array_map('trim' ,explode(",", str_replace("GRANT", "", explode("ON", $grant_string)[0])));

        $keys = ["SELECT", "INSERT", "UPDATE", "DELETE"];

        foreach ($keys as $key)
            $data[$key] = ( in_array($key, $permissions) ) ? "Yes" : "No";

        return array($data);
    }

}
