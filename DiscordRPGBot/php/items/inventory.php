<?php
class Inventory
{
    public $user        = null;

    public $currency    = 0;

    public $bag         = [];

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function AddItem(Item $item)
    {
        if(isset($this->bag[$item->name]))
            {$this->bag[$item->name]->quantity++;}
        else{$this->bag[$item->name] = clone $item;}
    }

    public function DiscardItem(string $itemName, int $quantity = 1)
    {
        if(isset($this->bag[$itemName]))
        {
            $numDiscarded = min($quantity, $this->bag[$itemName]->quantity);

            if($this->bag[$itemName]->quantity <= $quantity)
                {$this->bag[$itemName] = null;}
            else{$this->bag[$itemName]--;}

            return $numDiscarded;
        }
        else{return false;}
    }

    public function UseItem(string $itemName, $target)
    {

    }

    public function ListItems()
    {
        if(count($this->bag) > 0)
        {
            $itemNames = array_column($this->bag, 'name');
            return new Response('override', $this->user->name . ' has: ' . implode(', ', $itemNames));
        }
        else{return new Response('override', $this->user->name . ' has no items');}
    }
}
?>