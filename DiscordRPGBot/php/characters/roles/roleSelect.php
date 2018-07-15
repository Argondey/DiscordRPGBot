<?php
class RoleSelect
{
    private static $roles = 
        ['Fighter'
        ,'Mage'
        ,'Thief'];

    public function GetRole(string $name)
    {
        $name = ucwords(strtolower($name, self::$roles));
        if(array_search($name) !== false)
            {return new $name();}
        else{return null;}
    }
}
?>