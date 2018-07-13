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
        $this->lootTable = Item::$allItems;
    }

    public function GetLoot(User $user)
    {
        $timeSinceLastLoot = time() - $user->lastLoot;
        $lootCooldown = $user->guild->settings['lootCooldown'] * 60;
        if($timeSinceLastLoot > $lootCooldown)
        {
            $user->lastLoot = time();
            $item = $this->RandomLoot();
            $user->inventory->AddItem($item);
            return $item;
        }
        else return new Response('override', 'You cannot recieve loot yet. You can recieve loot again in ' . ($lootCooldown - $timeSinceLastLoot) . ' seconds.');
    }

    public function RandomLoot()
    {
        return $this->lootTable[array_rand($this->lootTable, 1)];
    }
}
?>