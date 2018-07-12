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
    protected static function GetConnection()
    {
        $dsn = "mysql:host="    . self::$dbhost
            . ";port="          . self::$dbport
            . ";dbname="        . self::$dbname
            . ";charset="       . self::$charset;
        self::$pdo = new PDO($dsn, Config::$databaseUsername, Config::$databasePassword);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$pdo;
    }

    //returns the active pdo instance if it exists, otherwise creates one
    public static function PDO()
    {
        if(self::$pdo == null)
            {return self::GetConnection();}
        else{return self::$pdo;}
    }

    //performs a database query
    //@param string $query A database query ready to use in a prepared statement, uses :var syntax where variables occur
    //@param array $params An associative array of parameter variables whose names match those in the query
    //@param int $pdoFetchType PDO fetch style, defaults to PDO::FETCH_ASSOC
    //@return returns the result of the query in the requested style
    public static function Query(string $query, array $params = [], int $pdoFetchType = PDO::FETCH_ASSOC)
    {
        $preparedStatement = self::PDO()->prepare($query);
        $preparedStatement->execute($params);
        $result = $preparedStatement->fetch($pdoFetchType);
        return $result;
    }
}
?>