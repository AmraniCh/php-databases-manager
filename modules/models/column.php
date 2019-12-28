<?php

class Column
{
    public $name;
    public $type;
    public $isAuto;

    public function __construct($name, $type, $isAuto)
    {
        $this->name = $name;
        $this->type = $type;
        $this->isAuto = $isAuto;
    }
}