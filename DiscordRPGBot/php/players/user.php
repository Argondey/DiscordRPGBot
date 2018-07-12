<?php
class User
{
    public $user = null;

    public $name    = '';
    public $id      = null;

    public $inventory = [];

    public function __construct(\CharlotteDunois\Yasmin\Models\User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->id   = $user->id;
    }

    public function AddItem(Item $item)
    {
        array_push($this->inventory, $item);
    }

    public function ListInventory()
    {
        $itemNames = array_column($this->inventory, 'name');
        return new Response('override', implode(', ', $itemNames));
    }
}
?>