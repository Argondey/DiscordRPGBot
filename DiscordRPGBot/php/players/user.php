<?php
class User
{
    public $user = null;

    public $name        = '';
    public $id          = null;
    public $guild       = null;

    public $inventory   = null;
    public $currency    = 0;

    public $lastLoot    = 0;

    public function __construct(\CharlotteDunois\Yasmin\Models\User $user)
    {
        $this->user         = $user;
        $this->name         = $user->username;
        $this->guild        = $user->guild;
        $this->id           = $user->id;

        $this->inventory    = new Inventory();
    }
}
?>