<?php
class Guild
{
    public static $guilds = [];

    public $name    = '';
    public $id      = null;
    public $guild   = null;

    public $players     = [];
    public $settings    = ['commandPrefix' => '$'];

    public function __construct(\CharlotteDunois\Yasmin\Models\Guild $guild)
    {
        $this->guild    = $guild;
        $this->name     = $guild->name;
        $this->id       = $guild->id;
    }

    public static function GetGuild(\CharlotteDunois\Yasmin\Models\Guild $guild)
    {
        if(!isset(self::$guilds[$guild->id]))
        {
            $newGuild = new Guild($guild);
            self::$guilds[$guild->id] = $newGuild;
            return $newGuild;
        }
        else{return self::$guilds[$guild->id];}
    }

    public function GetPlayer(\CharlotteDunois\Yasmin\Models\User $player)
    {
        if(!isset($this->players[$player->id]))
        {
            $newPlayer = new Player($player);
            $this->players[$player->id] = $newPlayer;
            return $newPlayer;
        }
        else{return $this->players[$player->id];}
    }
}
?>