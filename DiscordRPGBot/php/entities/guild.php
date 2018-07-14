<?php
class Guild extends Entity
{
    public static $guilds = [];

    public $id              = null;
    public $guild           = null;

    public $inventory       = null;

    public $users           = [];
    public $settings        = 
        //prefix to be used on every bot command
        ['commandPrefix'    => '$'
        //minutes between loot calls
        ,'lootCooldown'     => 1];

    public function __construct(\CharlotteDunois\Yasmin\Models\Guild $guild)
    {
        $this->id           = $guild->id;
        $this->guild        = $guild;
        $this->name         = $guild->name;
        $this->inventory    = new GuildInventory($this);
    }

    //gets a guild based on their object reference or creates a new one
    public static function GetGuild(\CharlotteDunois\Yasmin\Models\Guild $guild = null)
    {
        if($guild != null)
        {
            if(!isset(self::$guilds[$guild->id]))
                {self::$guilds[$guild->id] = new Guild($guild);}

            return self::$guilds[$guild->id];
        }
        else{return null;}
    }

    //get a user by their object reference or create a new one
    public function GetUser(\CharlotteDunois\Yasmin\Models\User $user)
    {
        if(!isset($this->users[$user->username]))
        {
            //check to see if we are storing this user with their username + discriminator
            if(isset($this->users[$user->username . '#' . $user->discriminator]))
            {
                //return user found with username and discriminator
                return $this->users[$user->username . '#' . $user->discriminator];
            }
            else
            {
                //create a new user listing for this person
                $this->users[$user->username] = new User($user, $this);
            }
        }
        //check if another user is already using this name
        else if($this->users[$user->username]->user != $user)
        {
            //username conflict, the new user must use the discriminator in all targetting requests
            $this->users[$user->username . '#' . $user->discriminator] = new User($user, $this);
            return $this->users[$user->username . '#' . $user->discriminator];
        }
        return $this->users[$user->username];
    }

    //try to get a user by name
    public function FindUser(string $name = null)
    {
        if(isset($this->users[$name]))
            {return $this->users[$name];}
        else{return null;}
    }
}
?>