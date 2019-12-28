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
     * Get all user
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

        /** checking password */
        session_start ();

        $_SESSION["user"] = $username;
        $_SESSION["pass"] = $password;

        return json_encode(true);
    }

    /**
     * Sign out
     */
    public static function signOut () { session_destroy (); }
}