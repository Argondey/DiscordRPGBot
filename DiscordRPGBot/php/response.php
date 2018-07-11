<?php
class Response
{
    public static $responseOptions = [];

    public $message = '';

    public function __construct($type = 'random', $data = null)
    { 
        switch($type)
        {
            case 'override' :
                $this->message = $data;
            default         :
            case 'random'   :
                $this->Random();
                break;
        }
    }

    public function Random()
    {
        $this->message = $this::$responseOptions[array_rand($this::$responses, 1)];
    }
}
?>