<?php
class Inventory
{
    public $gear = 
        ['mainHand'     => null
        ,'offHand'      => null
        ,'head'         => null
        ,'eyes'         => null
        ,'neck'         => null
        ,'shoulders'    => null
        ,'arms'         => null
        ,'hands'        => null
        ,'ring'         => null
        ,'torso'        => null
        ,'belt'         => null
        ,'legs'         => null
        ,'feet'         => null];

    public $entity = null;
    public $bag    = [];

    public function __construct(Entity $entity)
    {
    }

    //adds the passed item to this inventory
    public function Add(Item $item)
    {
        if(isset($this->bag[$item->name]))
        {
            $this->bag[$item->name]->quantity += $item->quantity;
            //if the added item and existing item have a different number of uses, add their uses together and adjust the quantity accordingly
            if($this->bag[$item->name]->uses != $item->uses)
            {
                $this->bag[$item->name]->quantity += floor(($this->bag[$item->name]->uses + $item->uses) / $item->maxUses);
                $this->bag[$item->name]->uses = ($this->bag[$item->name]->uses + $item->uses) % $item->maxUses;
            }
        }
        else{$this->bag[$item->name] = clone $item;}
    }

    //add an item to the slot it can occupy, removes an item from slot first if one exists, returns false if the item is slotless
    public function Equip(Item $item)
    {
        if(array_key_exists($item->slot, $this->gear))
        {
            $this->UnEquip($item->slot);
            $this->gear[$slot] = $item;
            return true;
        }
        else{return false;}
    }

    //remove an item from a gear slot, return true if an item was removed, false if there was no item to remove
    public function UnEquip(string $slot)
    {
        if(isset($this->gear[$slot]))
        {
            $item = $this->gear[$slot];
            $this->gear[$slot] = null;
            $this->Add($item);
            return true;
        }
        else{return false;}
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
                {return new DirectResponse($this->entity->name . ' has no items of the type "' . $type . '"');}

            $list = new DirectResponse($this->entity->name . ' has: ' . implode(', ', $items));
            if($type != '')
                {$list->Append(' which are of the type "' . $type . '"');}

            return $list;
        }
        else{return new DirectResponse($this->entity->name . ' has no items');}
    }

    //deletes an item from this inventory, returns the number of deleted items
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