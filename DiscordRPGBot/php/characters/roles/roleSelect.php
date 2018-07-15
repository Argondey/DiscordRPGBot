<?php
class RoleSelect
{
    private static $roles = 
        ['Fighter'
        ,'Mage'
        ,'Thief'];

    public function GetRole(string $name)
    {
        $name = ucwords(strtolower($name));
        $roleIndex = array_search($name, self::$roles);
        if($roleIndex !== false)
            {return new self::$roles[$roleIndex]();}
        else{return null;}
    }
}
?>