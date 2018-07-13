<?php
class Inventory
{
    public $user        = null;

    public $currency    = 0;

    public $bag         = [];

    public function __construct()
    {
    }

    public function AddItem(Item $item)
    {
        if(isset($this->bag[$item->name]))
            {$this->bag[$item->name]->quantity++;}
        else{$this->bag[$item->name] = clone $item;}
    }

    public function DiscardItem(string $itemName, int $quantity)
    {
        if(isset($this->bag[$item->name]))
        {
            if($this->bag[$item->name]->quantity <= $quantity)
                {$this->bag[$item->name] = null;}
            else{$this->bag[$item->name]--;}

            return true;
        }
        else{return false;}
    }

    public function UseItem(string $itemName, $target)
    {

    }

    public function ListInventory()
    {
        $itemNames = array_column($this->bag, 'name');
        return new Response('override', implode(', ', $itemNames));
    }
}
?>