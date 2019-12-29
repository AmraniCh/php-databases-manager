<?php

class Manager implements Container
{
    public $connection;
    /**
     * Array of Database instances
     */
    public $databases;

    function __construct($host, $user, $pass)
    {
        $this->connect ($host, $user, $pass);
        $this->databases = [];

        foreach ($this->getDatabaseNames () as $dbName)
            $this->add ($this->loadDatabase ($dbName));
    }

    public function connect ($host, $user, $pass)
    {
        $this->connection = new mysqli($host, $user, $pass);
    }

    /**
     * Load all databases names
     */
    public function getDatabaseNames ()
    {
        $set = $this->connection->query ('SHOW DATABASES;');

        $names = [];

        // Except already existed databases
        $exceptions = ["information_schema", "performance_schema", "phpmyadmin", "mysql", "sys"];

        while($db = $set->fetch_row())
            if (!in_array($db[0], $exceptions))
                $names[] = $db[0];

        return $names;
    }

    public function loadDatabase ($databaseName)
    {
        return new Database ($databaseName, $this->connection);
    }

    public function getDatabase ($databaseName)
    {
        foreach ($this->databases as $d)
            if (strcmp ($d->name, $databaseName) == 0)
                return $d;

        return null;
    }

    public function getTable ($databaseName, $tableName)
    {
        return $this->getDatabase ($databaseName)->getTable ($tableName);
    }

    public function fetchDatabasesJSON ()
    {
        $arr = [];

        foreach ($this->databases as $d)
            $arr[] = [
                "name" => $d->name,
                "size" => 0,
                "count" => $d->count()
            ];

        return ["databases" => $arr, "count" => $this->count ()];
    }

    public function add ($item)
    {
        $this->databases[] = $item;
    }

    public function remove ($item)
    {}

    public function count()
    {
        return count ($this->databases);
    }
}
