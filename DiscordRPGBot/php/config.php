<?php
class Config
{
    //------------------------------------------------------------------------------------//
    //Database Connection Credentials
    public static $dbhost   = "rpgbot.ckpitfzeowvu.us-west-1.rds.amazonaws.com:3306";
    public static $dbname   = "RPGBot";
    public static $dbport   = "3306";
    public static $charset  = "utf8";    
    //filled by environment variables on construction of class
    public static $dbUsername = null;
    public static $dbPassword = null;
    //------------------------------------------------------------------------------------//

    //yasmin instance that connects to the discord api
    public static $yasmin = null;
    //react event loop
    public static $eventLoop = null;

    //logging level
    //0 = none; 1 = minimal; 2 = normal; 3 = verbose;
    public static $logLevel = 1;

    //token used to authenticate with discord
    //set to matching environment variable on construct
    public static $discordToken = null;
    
    public function __construct()
    {
        //require composer autoloader
        require(__DIR__.'/../../composer/vendor/autoload.php');

        //grab environment variables
        $this::$discordToken        = getenv('DISCORD_TOKEN');
        $this::$databaseUsername    = getenv('DATABASE_USERNAME');
        $this::$databasePassword    = getenv('DATABASE_PASSWORD');

        //create reactphp eventloop
        $this::$eventLoop = \React\EventLoop\Factory::create();

        // Create the client
        $this::$yasmin = new \CharlotteDunois\Yasmin\Client([], $this::$eventLoop);
        $this::$yasmin->login($this::$discordToken);
        $this::$yasmin->on('ready', function ()
        {
            echo 'Successfully logged in!' . PHP_EOL;
        });
    }
}
?>