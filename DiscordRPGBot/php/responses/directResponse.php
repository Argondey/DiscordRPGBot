<?php
class DirectResponse extends Response
{
    //creates a response directly from a passed string
    public function __construct($data = null, bool $formatted = false)
    { 
        parent::__construct($data, $formatted);
        $this->message = $data;
    }
}
?>