<?php

class Column
{
    public $name;
    public $type;
    public $isPrimary;
    public $isAuto;

    public function __construct($name, $type, $isAuto, $isPrimary)
    {
        $this->name = $name;
        $this->type = $type;
        $this->isAuto = $isAuto;
        $this->isPrimary = $isPrimary;
    }
}