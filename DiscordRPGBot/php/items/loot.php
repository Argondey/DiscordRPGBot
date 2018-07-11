<?php
class Loot
{
    public $lootTable = [];

    public function __construct()
    {
        $this->CreateLoot();
    }

    public function CreateLoot()
    {
        $this->lootTable = [new Hammer(), new Pistol(), new Rapier(), new Shield(), new Sword()];
    }

    public function GetLoot()
    {
        return $this->RandomLoot();
    }

    public function RandomLoot()
    {
        return $this->lootTable[array_rand($this->lootTable, 1)];
    }
}
?>