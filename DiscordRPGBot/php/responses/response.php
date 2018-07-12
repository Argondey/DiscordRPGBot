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
                break;
            case 'random'   :
            default         :
                $this->message = $this->Random();
                break;
        }
    }

    public function Random()
    {return $this::$responseOptions[array_rand($this::$responseOptions, 1)];}
}
?>