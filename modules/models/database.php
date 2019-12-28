<?php

class Database implements Container
{
    public $name;
    private $connection;
    /**
     * Array of Table instances
     */
    public $tables;

    public function __construct($name, $connection)
    {
        $this->name = $name;
        $this->connection = $connection;

        $this->connection->select_db ($name);

        $this->loadTables();
    }

    /**
     * Array of strings
     */
    public function getTableNames ()
    {
        $r = QueryHelper::exec_query(
            QueryHelper::get_tables($this->name),
            $this->connection
        );

        $names = [];

        foreach ($r as $i)
            $names[] = $i["TABLE_NAME"];

        return $names;
    }

    public function loadTable ($tableName)
    {
        return new Table($tableName, $this->name, $this->connection);
    }

    public function loadTables ()
    {
        $this->tables = [];

        foreach ($this->getTableNames() as $n)
            $this->add ($this->loadTable ($n, $this->name, $this->connection));
    }

    public function getTable ($tableName)
    {
        foreach ($this->tables as $t)
            if (strcmp ($t->name, $tableName) == 0)
                return $t;

        return !true;
    }

    public function add ($item)
    {
        $this->tables[] = $item;
    }

    /**
     * Useless method
     */
    public function remove ($item)
    {}

    public function count ()
    {
        return count ($this->tables);
    }

    /**
     * Method for fetching tables in a custom JSON structure
     */
    public function fetchTablesJSON ()
    {
        $tables = [];

        foreach ($this->tables as $t) 
            $tables[] = [
                "name" => $t->name,
                "size" => $t->size, 
                "count" => $t->count()
            ];

        return $tables;
    }
}