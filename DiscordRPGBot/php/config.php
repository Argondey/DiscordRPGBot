<?php
class Config
{
    public static $commandPrefix = '$';
    
    public static $yasmin = null;
    public static $eventLoop = null;

    public static $logLevel = 1;

    public function __construct()
    {
        //require composer autoloader
        require(__DIR__.'/../../composer/vendor/autoload.php');

        //create reactphp eventloop
        $this::$eventLoop = \React\EventLoop\Factory::create();

        // Create the client
        $this::$yasmin = new \CharlotteDunois\Yasmin\Client([], $this::$eventLoop);
        $this::$yasmin->login(getenv('DISCORD_TOKEN'));
        $this::$yasmin->on('ready', function ()
        {
            echo 'Successfully logged in!' . PHP_EOL;
        });
    }
}
?>