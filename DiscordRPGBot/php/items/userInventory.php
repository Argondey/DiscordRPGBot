<?php
class UserInventory extends Inventory
{
    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    //drops the passed quantity of the passed item onto the guild inventory
    //returns the number of items dropped if successful, otherwise returns false
    public function Discard(string $itemName, int $quantity = 1)
    {
        $item = $this->Retrieve($itemName);
        if($item != null)
        {
            $this->entity->guild->inventory->Add($item);
            return $item->quantity;
        }
        else{return false;}
    }
}
?>