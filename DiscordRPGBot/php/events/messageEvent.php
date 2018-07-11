<?php
class MessageEvent
{
    public function __construct($message)
    {
        if(substr($message->content, 0, 1) == Config::$commandPrefix)
        {
            $content = explode(' ', substr($message->content, 1));
            switch($content[0])
            {
                case'Hello':
                    $message->channel->send(new Greeting());
                case'ChangePrefix':
                    $len = strlen($content[1] == 1);
                    if($len == 1)
                    {
                        Config::$commandPrefix = $content[1];
                        $message->channel->send('Prefix changed to ' . $content[1]);
                    }
                    else if($len == 0)
                        {$message->channel->send('No replacement prefix was sent');}
                    else{$message->channel->send('New prefix was more than 1 character! Only 1 character prefixes are allowed.');}
                default:
                    return new Confusion();
            }
        }
    }
}
?>