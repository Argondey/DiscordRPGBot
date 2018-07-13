<?php
class Guild
{
    public static $guilds = [];

    public $name            = '';
    public $id              = null;
    public $guild           = null;

    public $users           = [];
    public $settings        = 
        //prefix to be used on every bot command
        ['commandPrefix'    => '$'
        //minutes between loot calls
        ,'lootCooldown'     => 1];

    public function __construct(\CharlotteDunois\Yasmin\Models\Guild $guild)
    {
        $this    = $guild;
        $this->name     = $guild->name;
        $this->id       = $guild->id;
    }

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

    public function GetUser(\CharlotteDunois\Yasmin\Models\User $user)
    {
        if(!isset($this->users[$user->id]))
            {$this->users[$user->id] = new User($user, $this);}

        return $this->users[$user->id];
    }
}
?>