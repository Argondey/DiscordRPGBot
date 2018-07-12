<?php
class Database
{
    //------------------------------------------------------------------------------------//
    //Database Connection Credentials
    public static $dbhost   = "rpgbot.ckpitfzeowvu.us-west-1.rds.amazonaws.com:3306";
    public static $dbname   = "RPGBot";
    public static $dbport   = "3306";
    public static $charset  = "utf8";    
    //------------------------------------------------------------------------------------//

    protected static $pdo  = null;

    //this function returns a connection to the database
    protected static function GetConnection(string $databaseName)
    {
        $dsn = "mysql:host="    . self::$dbhost
            . ";port="          . self::$dbport
            . ";dbname="        . $databaseName
            . ";charset="       . Config::$database['charset'];
        self::$pdo = new PDO($dsn, Config::$database['username'], Config::$database['password']);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$pdo;
    }

    public static function PDO()
    {
        if(self::$pdo == null)
            {return self::GetConnection();}
        else{return self::$pdo;}
    }

    public static function Query(string $query, array $params)
    {
        $preparedStatement = self::PDO()->prepare($query);
        $preparedStatement->execute($params);
        $result = $preparedStatement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>