<?php
class Logger
{
    private static $log = [];

    public static function Log($message)
    {
        array_push(self::$log, $message);
        if(Config::$logLevel > 0)
        {
            echo $message;
        }
    }
}
?>