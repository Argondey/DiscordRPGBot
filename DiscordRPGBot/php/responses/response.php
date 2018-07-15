<?php
abstract class Response
{
    //whether this response handles its own formatting, meaning we shouldn't try to guess at how it should look
    public $formatted = false;

    //the string that will be used as a response
    public $message = '';

    //creates a response, type indicates what rules will govern the response
    public function __construct($data = null, $formatted = false)
    { 
        Logger::Log(get_called_class() . ' was created');
        $this->formatted = $formatted;
    }

    //when something attempts to get the message contents, we apply some auto-formatting to help it look good
    public function __get($name)
    {
        switch($name)
        {
            default:
                return $this->$name;
            case 'message':
                $lastChar = substr($this->message, -1);
                switch($lastChar)
                {
                    case ($this->formatted) :
                    case '.'                :
                    case '?'                :
                    case '!'                :
                    case ';'                :
                    return $this->message;
                    default:
                        return $this->message . '.';
                }
        }
    }

    //add text to the end of the message
    public function Append(string $string)
    {$this->message .= $string;}

    //add text to the beggining of the message
    public function Prepend(string $string)
    {$this->message = $string . $this->message;}
}
?>