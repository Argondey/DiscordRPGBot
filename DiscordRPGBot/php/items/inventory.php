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

    public function DiscardItem(string $itemName, int $quantity = 1)
    {
        if(isset($this->bag[$item->name]))
        {
            $numDiscarded = min($quantity, $this->bag[$item->name]->quantity);

            if($this->bag[$item->name]->quantity <= $quantity)
                {$this->bag[$item->name] = null;}
            else{$this->bag[$item->name]--;}

            return $numDiscarded;
        }
        else{return false;}
    }

    public function UseItem(string $itemName, $target)
    {

    }

    public function ListItems()
    {
        $itemNames = array_column($this->bag, 'name');
        return new Response('override', implode(', ', $itemNames));
    }
}
?>