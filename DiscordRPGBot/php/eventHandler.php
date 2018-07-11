<?php
class EventHandler
{
    private $eventLoop = null;

    public function __construct($eventLoop, $yasmin)
    {
        $this->eventLoop = $eventLoop;

        $yasmin->on('message', function (\CharlotteDunois\Yasmin\Models\Message $message) 
        {$this->Event('message', $message);});

        $this->Listen();
    }

    public function Event($type = null, $data = null)
    {
        Logger::Log('Event handler was called.');
        $result = null;
        switch($type)
        {
            case 'message':
                $result = new MessageEvent($data);
            default:
                $result = new Confusion();
        }

        if(is_a($result, 'Response'))
        {
            $data->channel->send($result->message);
            Logger::Log('Attempted to send a response.');
        }
        else
        {
            $data->channel->send('Event result was not a response.');
            Logger::Log('Attempted to send a failure message.');
        }
    }

    public function Listen()
    {
        $this->eventLoop->run();
    }
}
?>