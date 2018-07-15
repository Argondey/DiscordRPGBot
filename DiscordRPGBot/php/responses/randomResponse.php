<?php
abstract class RandomResponse extends Response
{
    //array of string responses to use when randomly generating a response
    public static $responseOptions = [];

    //creates a random response from a list of possibilities
    public function __construct($data = null, bool $formatted = false)
    { 
        parent::__construct($data, $formatted);
        $this->message = $this->Random();
    }

    //generate a random message
    public function Random()
    {return $this::$responseOptions[array_rand($this::$responseOptions, 1)];}
}
?>