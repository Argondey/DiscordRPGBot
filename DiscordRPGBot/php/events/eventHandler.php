<?php
class EventHandler
{
    private $eventLoop = null;

    public function __construct($eventLoop, $yasmin)
    {
        $this->eventLoop = $eventLoop;

        $yasmin->on('message', function(\CharlotteDunois\Yasmin\Models\Message $message) 
        {$this->Event('message', $message);});

        $yasmin->on('error', function($error) 
        {var_dump($error);});

        $this->Listen();
    }

    public function Event($type = null, $data = null)
    {
        Logger::Log('Event handler was called.');
        $result = null;
        switch($type)
        {
            case 'message':
                try{$result = MessageEvent::HandleEvent($data);}
                catch(Exception $error)
                {
                    $result = new Confusion();
                    var_dump($error);
                }
                break;
            default:
                return null;
                break;
        }

        if(is_a($result, 'Response'))
        {
            $data->channel->send($result->message);
            Logger::Log('Attempted to send a response.');
        }
    }

    public function Listen()
    {
        $this->eventLoop->run();
    }
}
?>