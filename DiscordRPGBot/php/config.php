<?php
class Config
{
    public static $commandPrefix = '$';
    
    public static $yasmin = null;
    public static $eventLoop = null;

    public static $logLevel = 1;

    public static $discordToken = null;
    public static $databaseUsername = null;
    public static $databasePassword = null;

    public function __construct()
    {
        //require composer autoloader
        require(__DIR__.'/../../composer/vendor/autoload.php');

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