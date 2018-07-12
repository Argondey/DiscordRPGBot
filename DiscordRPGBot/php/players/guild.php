<?php
class Guild
{
    public static $guilds = [];

    public $name        = '';
    public $id          = null;
    public $guild       = null;

    public $users       = [];
    public $settings    = ['commandPrefix' => '$'];

    public function __construct(\CharlotteDunois\Yasmin\Models\Guild $guild)
    {
        $this->guild    = $guild;
        $this->name     = $guild->name;
        $this->id       = $guild->id;
    }

    public static function GetGuild(\CharlotteDunois\Yasmin\Models\Guild $guild = null)
    {
        if($guild != null)
        {
            if(!isset(self::$guilds[$guild->id]))
            {
                $newGuild = new Guild($guild);
                self::$guilds[$guild->id] = $newGuild;
                return $newGuild;
            }
            else{return self::$guilds[$guild->id];}
        }
        else{return null;}
    }

    public function GetPlayer(\CharlotteDunois\Yasmin\Models\User $user)
    {
        if(!isset($this->users[$user->id]))
        {
            $newUser = new User($user);
            $this->users[$user->id] = $newUser;
            return $newUser;
        }
        else{return $this->users[$user->id];}
    }
}
?>