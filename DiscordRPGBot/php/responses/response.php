<?php
class Response
{
    //array of string responses to use when randomly generating a response
    public static $responseOptions = [];

    //whether this response handles its own formatting, meaning we shouldn't try to guess at how it should look
    public $formatted = false;

    //the string that will be used as a response
    public $message = '';

    //creates a response, type indicates what rules will govern the response
    public function __construct($type = 'random', $data = null, $formatted = false)
    { 
        $this->formatted = $formatted;
        
        switch($type)
        {
            case 'generated':
                $this->Generate();
            case 'override' :
                $this->message = $data;
                break;
            case 'random'   :
            default         :
                $this->message = $this->Random();
                break;
        }
    }

    //this function is overriden in child classes to allow for specific rules on generating a response
    public function Generate(){}

    //when something attempts to get the message contents, we apply some auto-formatting to help it look good
    public function __get($name)
    {
        switch($name)
        {
            default:
                return $this->$name;
            case 'message':
                if(substr($this->message, -1) === '.' || $this->formatted)
                    {return $this->message;}
                else{return $this->message . '.';}
        }
    }

    //add text to the end of the message
    public function Append(string $string)
    {$this->message .= $string;}

    //add text to the beggining of the message
    public function Prepend(string $string)
    {$this->message = $string . $this->message;}

    //generate a random message
    public function Random()
    {return $this::$responseOptions[array_rand($this::$responseOptions, 1)];}
}
?>