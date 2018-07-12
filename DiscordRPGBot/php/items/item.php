<?php
class Item
{
    public $name = '';

    public $quality = '';

    public $description = '';

    public function Describe()
    {
        return new Response('override', 'A ' . $this->name . ' of ' . $this->quality . ' quality. ' . $this->description);
    }

    public function GetAll()
    {
        
    }
}
?>