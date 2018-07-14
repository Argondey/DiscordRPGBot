<?php
class Inventory
{
    public $entity = null;

    public $currency    = 0;
    public $bag         = [];

    public function __construct(Entity $entity)
    {
    }

    //adds the passed item to this inventory
    public function Add(Item $item)
    {
        if(isset($this->bag[$item->name]))
        {
            $this->bag[$item->name]->quantity++;
            //if the added item and existing item have a different number of uses, add their uses together and adjust the quantity accordingly
            if($this->bag[$item->name]->uses != $item->uses)
            {
                $this->bag[$item->name]->quantity += floor(($this->bag[$item->name]->uses + $item->uses) / $item->maxUses);
                $this->bag[$item->name]->uses = ($this->bag[$item->name]->uses + $item->uses) % $item->maxUses;
            }
        }
        else{$this->bag[$item->name] = clone $item;}
    }

    //expend a use of an item to cause the target to recieve the item's active effect
    //
    public function Use(string $itemName)
    {
        if($this->bag[$itemName])
        {
            $item = $this->bag[$itemName];
            if($item->maxUses != -1)
            {
                $item->uses--;
                if($item->uses == 0)
                    {unset($this->bag[$itemName]);}
            }
            return true;
        }
        else{return false;}
    }

    //returns ' has: ' followed by a comma seperated list of items and their quantities
    //returns 'has no items' if the inventory does not have any items
    //optionally may only include items of the selected type
    public function List(string $type = '')
    {
        if(count($this->bag) > 0)
        {
            $bagKeys = array_keys($this->bag);
            $items = [];

            for($i = 0; $i < count($bagKeys); $i++)
            {
                $item = $this->bag[$bagKeys[$i]];
                if($type == '' || $item->type == $type)
                    {array_push($items, $item->name . ' x' . $item->quantity);}
            }
            if($type != '' && count($items) == 0)
                {return new Response('override', $this->entity->name . ' has no items of the type "' . $type . '"');}

            $list = new Response('override', $this->entity->name . ' has: ' . implode(', ', $items));
            if($type != '')
                {$list->Append(' which are of the type "' . $type . '"');}

            return $list;
        }
        else{return new Response('override', $this->entity->name . ' has no items');}
    }

    public function Remove(string $itemName, int $quantity = 1)
    {
        if(isset($this->bag[$itemName]))
        {
            $numRemoved = min($quantity, $this->bag[$itemName]->quantity);

            if($this->bag[$itemName]->quantity <= $quantity)
                {unset($this->bag[$itemName]);}
            else
            {
                $this->bag[$itemName]->quantity -= $quantity;
                $this->bag[$itemName]->uses = $this->bag[$itemName]->maxUses;
            }
            
            return $numRemoved;
        }
        else{return false;}
    }

    //Gets an item from this inventory, returns the item for use elsewhere
    public function Retrieve(string $itemName, int $quantity = 1)
    {
        if(isset($this->bag[$itemName]))
        {
            $item           = clone $this->bag[$itemName];
            $numRemoved     = $this->Remove($itemName, $quantity);
            $item->quantity = $numRemoved;
            return $item;
        }
        else{return null;}
    }
}
?>