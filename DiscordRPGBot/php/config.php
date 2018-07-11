<?php
class Config
{
    public static $commandPrefix = '$';
    public static $yasmin = null;

    private $eventLoop = null;
    public function GetEventLoop()
    {return $this->eventLoop;}

    public function __construct()
    {
        //require composer autoloader
        require(__DIR__.'/vendor/autoload.php');

        //create reactphp eventloop
        $this->eventLoop = \React\EventLoop\Factory::create();

        // Create the client
        $this::$yasmin = new \CharlotteDunois\Yasmin\Client([], $this->eventLoop);
        $this::$yasmin->login(getenv('DISCORD_TOKEN'));
        $this::$yasmin->on('ready', function () use ($yasmin)
        {
            echo 'Successfully logged in!'.PHP_EOL;
        });
    }
}
?>