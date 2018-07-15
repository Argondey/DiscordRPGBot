<?php
abstract class GeneratedResponse extends Response
{
    //creates a random response based on defined criteria
    public function __construct($data = null, bool $formatted = false)
    { 
        parent::__construct($data, $formatted);
        $this->Generate();
    }

    //this function is overriden in child classes to allow for specific rules on generating a response
    public abstract function Generate();
}
?>