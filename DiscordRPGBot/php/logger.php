<?php
class Logger
{
    private static $log = [];

    public static function Log($message, $levelRequirement = 1)
    {
        array_push(self::$log, $message);
        if(Config::$logLevel >= $levelRequirement)
        {
            echo $message . PHP_EOL;
        }
    }
}
?>