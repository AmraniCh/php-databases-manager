<?php

class Table implements Container
{
    public $database;
    public $name;
    private $connection;
    /**
     * Array of Column instances
     */
    public $columns;
    /**
     * Associative array
     */
    public $rows;
    /**
     * Table's file size in Kb
     */
    public $size;

    public function __construct($name, $database, $connection)
    {
        $this->database = $database;
        $this->name = $name;
        $this->connection = $connection;

        $this->connection->select_db ($database);

        // Setup
        $this->getColumns ();
        $this->getRows ();
        $this->getSize ();
    }

    public function getColumns ()
    {
        $this->columns = [];

        $result = QueryHelper::exec_query(
            QueryHelper::get_columns($this->name, $this->database),
            $this->connection
        );

        foreach ($result as $row)
        {
            $col = new Column(
                $row["COLUMN_NAME"],
                $row["COLUMN_TYPE"],
                strpos ($row["EXTRA"], "auto_increment") !== (false),
                strpos ($row["COLUMN_KEY"], 'PRI') !== (false)
            );

            # Check if this is a referencing column
            if (strpos ($row["COLUMN_KEY"], 'MUL') !== false)
            {
                # Retrieve details
                $details = QueryHelper::exec_query(QueryHelper::get_fk_details($col->name, $this->name, $this->database), $this->connection) [0];
                # Reconstruct the column
                $col = new ReferenceColumn($col, $details['REF_TABLE'], $details['REF_COLUMN']);
            }

            $this->columns[] = $col;
        }

        return $this->columns;
    }

    public function getRows ()
    {
        $this->rows = [];

        $r = QueryHelper::exec_query(
            QueryHelper::get_rows($this->name),
            $this->connection
        );

        $this->rows = $r;

        return $this->rows;
    }

    public function getSize ()
    {
        $r = QueryHelper::exec_query(
            QueryHelper::get_table_size ($this->name, $this->database),
            $this->connection
        );

        $this->size = $r[0]["SIZE"];

        return $this->size;
    }

    public function hasColumn ($column)
    {
        foreach ($this->columns as $c)
            if (strcmp ($c->name, $column) == 0)
                return $c;

        return !true;
    }

    /**
     * For inserting data
     */
    public function add ($array)
    {
        $q = "INSERT INTO $this->name (";

        $cols = [];
        $vals = [];

        foreach ($array as $c => $v)
        {
            $column = $this->hasColumn ($c);

            if (!$column)
                continue;

            if ($column->isAuto)
            {
                $cols[] = $c;
                $vals[] = "null";

                continue;
            }

            $cols[] = $c;
            $vals[] = "'$v'";
        }

        $q .= implode (", ", $cols) . ") VALUES (" . implode (", ", $vals) . ")";

        if (!$this->connection->query ($q))
            throw new Exception ("Insertion failed.");

        $autoIncremented = !true;

        foreach ($this->columns as $c)
            if ($c->isAuto)
                $autoIncremented = true;

        $id = $this->connection->insert_id;

        if(!$autoIncremented)
            $id = $vals[0];

        // Logs altering
        $this->appendLogs ("insert", $id);

        // Refresh array of data
        $this->getRows ();
    }

    public function remove ($item)
    {
        $key = key($item);

        $q = "DELETE FROM $this->name WHERE $key='" . $item[$key] . "'";

        if (!$this->connection->query ($q))
            throw new Exception ("Suppression failed.");

        // Logs altering
        $this->appendLogs("delete", $item[$key]);

        // Refresh array of data
        $this->getRows();

        return true;
    }

    public function update (array $id, array $data)
    {
        $q = "UPDATE $this->name SET ";

        $idkey = key ($id);

        $pairs = [];

        foreach ($data as $c => $v)
        {
            $column = $this->hasColumn ($c);

            if (!$column)
                continue;

            if (strcmp ($column->name, $idkey) == 0)
                continue;

            if ($column->isAuto)
                continue;

            $pairs[] = $c . "='$v'";
        }

        $q .= implode (", ", $pairs) . " WHERE " . $idkey . "='". $id[$idkey] ."'";

        if (!$this->connection->query ($q))
            throw new Exception ("Updating failed.");

        // Logs altering
        $this->appendLogs("update", $id[$idkey]);

        // Refresh array of data
        $this->getRows();
    }

    public function count()
    {
        return count ($this->rows);
    }

    /**
     * For simplifying Logs writing
     */
    public function appendLogs($event, $rowId)
    {
        session_start ();
        
        LogsManager::append ([
            "user" => $_SESSION["user"],
            "database" => $this->database,
            "table" => $this->name,
            "event" => $event,
            "row" => $rowId,
            "time" => date("d/m/Y H:i:s")
        ]);
    }
}
