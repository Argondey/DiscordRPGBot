<?php
abstract class ItemBase
{
    public static $allItems = [];

    public static $qualities = 
        [0  => 'laughable'
        ,1  => 'pathetic'
        ,2  => 'miserable'
        ,3  => 'meager'
        ,4  => 'shabby'
        ,5  => 'poor'
        ,6  => 'common'
        ,7  => 'decent'
        ,8  => 'fine'
        ,9  => 'rare'
        ,10 => 'unique'
        ,11 => 'legendary'
        ,12 => 'mythic'
        ,13 => 'godly'
        ,14 => 'lost'
        ,15 => 'forbidden'];

    public static $types = 
        [0 => 'weapon'
        ,1 => 'armor'
        ,2 => 'magic'
        ,3 => 'tool'
        ,4 => 'food'
        ,5 => 'potion'
        ,6 => 'crafting'
        ,7 => 'money'];
    
    public static $slots = 
        [0  => 'bag'
        ,1  => 'mainHand'
        ,2  => 'offHand'
        ,3  => 'head'
        ,4  => 'eyes'
        ,5  => 'neck'
        ,6  => 'shoulders'
        ,7  => 'arms'
        ,8  => 'hands'
        ,9  => 'ring'
        ,10 => 'torso'
        ,11 => 'belt'
        ,12 => 'legs'
        ,13 => 'feet'];

    public static function Find(string $name)
    {
        $names = array_column(self::$allItems);
        $index = array_search($name, $names);
        if($index === false)
            {return false;}
        else{return self::$allItems[$index];}
    }

    public static function LoadItems()
    {
        $items = Database::Query('SELECT * FROM RPGBot.items;');
        for($i = 0; $i < count($items); $i++)
            {self::$allItems[$items[$i]['name']] = new Item($items[$i]);}

        Logger::Log(count($items) . ' items successfully loaded.');
    }
}
?>