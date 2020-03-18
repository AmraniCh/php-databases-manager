<?php

class ReferenceColumn
    extends Column
{
    public $referenced_table;
    public $referenced_column;

    public function __construct($column, $refTable, $refColumn)
    {
        parent::__construct ($column->name, $column->type, $column->isAuto, $column->isPrimary);

        $this->referenced_table = $refTable;
        $this->referenced_column = $refColumn;
    }
}