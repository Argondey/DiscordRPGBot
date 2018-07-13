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
                {unset($this->bag[$itemName]);}
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
            $bagKeys = array_keys($this->bag);
            $items = [];

            for($i = 0; $i < count($bagKeys); $i++)
            {
                $item = $this->bag[$bagKeys[$i]];
                array_push($items, $item->name . ' x' . $item->quantity);
            }
            return new Response('override', $this->user->name . ' has: ' . implode(', ', $items));
        }
        else{return new Response('override', $this->user->name . ' has no items');}
    }
}
?>