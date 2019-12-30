<?php

class LogsManager
{
    public static $logs = array();
    public static $path;

    public static function fixPath ()
    {
        self::$path = $_SERVER["DOCUMENT_ROOT"] . "/DatabaseManagerAPI/logs/logs.txt";
    }

    public static function read()
    {
        self::fixPath ();

        $file = fopen(self::$path, "r");

        self::$logs = array();

        while (!feof($file)) {
            $row = fgets($file);

            if (strlen($row) > 0) {
                $dataArray = explode(";", $row);
                array_push(self::$logs, [
                    "user" => $dataArray[0],
                    "database" => $dataArray[1],
                    "table" => $dataArray[2],
                    "event" => $dataArray[3],
                    "id" => $dataArray[4],
                    "time" => $dataArray[5]
                ]);
            }
        }

        fclose($file);

        return self::$logs;
    }

    public static function filter($arr)
    {
        if (count (self::$logs) == 0)
            self::read();

        $filteredArray = array();
        foreach (self::$logs as $logRow)
        {
            $counter = 0;
            foreach ($arr as $filterColumn => $filterValue) {
                foreach ($logRow as $columnName => $value) {
                    if ($filterColumn == $columnName && $value == $filterValue) {
                        $counter++;
                        break;
                    }
                }
                if ($counter == count($arr)) {
                    array_push($filteredArray, $logRow);
                }
            }
        }
        return $filteredArray;
    }

    public static function append($arr)
    {
        self::fixPath ();

        $file = fopen(self::$path, "a+");

        fwrite($file, implode(";", $arr));

        fclose($file);
    }

    public static function clear()
    {
        self::fixPath ();

        unlink(self::$path);
    }
}
