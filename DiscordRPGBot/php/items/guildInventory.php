<?php
class GuildInventory extends Inventory
{
    public function __construct(Guild $guild)
    {
        $this->entity = $guild;
    }

    //adds ' on the ground' to the end of an inventory list
    public function ListItems()
    {return parent::ListItems()->Append(' on the ground');}
}
?>