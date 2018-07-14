<?php
class User extends Entity
{
    public $user    = null;
    public $id      = null;
    public $guild   = null;

    public $discriminator       = 0;
    public $useDiscriminator    = false;

    public $inventory   = null;
    public $lastLoot    = 0;

    public function __construct(\CharlotteDunois\Yasmin\Models\User $user, Guild $guild, bool $useDiscriminator = false)
    {
        $this->user         = $user;
        $this->name         = $user->username;
        $this->discriminator = $user->discriminator;
        $this->useDiscriminator = $useDiscriminator;
        $this->guild        = $guild;
        $this->id           = $user->id;

        $this->inventory    = new UserInventory($this);
    }

    //return name + discriminator combination if user is marked to use discriminator
    public function __get($var)
    {
        switch($var)
        {
            case 'name':
                if($this->useDiscriminator)
                    {return $this->name . '#' . $this->discriminator;}
                else{return $this->name;}
            default:
                return $this->$var;
        }
    }
}
?>