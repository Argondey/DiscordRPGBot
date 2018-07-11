<?php
class EventHandler
{
    private $eventLoop = null;

    public function __construct($eventLoop, $yasmin)
    {
        $this->eventLoop = $eventLoop;

        $client->on('message', function (\CharlotteDunois\Yasmin\Models\Message $message) 
        {$this->Event('message', $message);});

        $this->Listen();
    }

    public function Event($type = null, $data = null)
    {
        $result = null;
        switch($event)
        {
            case 'message':
                $result =  new MessageEvent($data);
            default:
                $result =  new Confusion();
        }

        if(is_a($result, 'Response'))
        {
            $message->channel->send($result->message);
        }
    }

    public function Listen()
    {
        $this->eventLoop->run();
    }
}
?>