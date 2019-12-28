<?php

class LogsManager
{
    public static $logs = array();
    public static $path = "../../logs/logs.txt";

    public static function read()
    {
        $file = fopen(self::$path, "r");

        self::$logs = array();

        while (!feof($file)) {
            $row = fgets($file);

            if (strlen($row) > 0) {
                $dataArray = explode(";", $row);
                array_push(self::$logs, ["user" => $dataArray[0], "database" => $dataArray[1], "table" => $dataArray[2], "event" => $dataArray[3], "id" => $dataArray[4]]);
            }
        }
        fclose($file);
    }

    public static function filter($arr)
    {
        $filteredArray = array();
        foreach (self::$logs as $logRow) {
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
        $file = fopen(self::$path, "a+");

        fwrite($file, implode(";", $arr) . "\r\n");

        fclose($file);
    }

    public static function clear()
    {
        unlink(self::$path);
    }
}
