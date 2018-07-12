<?php
class Item
{
    public static $allItems = [];

    public static $qualityMap = 
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

    public $name = '';

    public $quality = null;

    public $description = '';

    public function __construct(array $args)
    {
        if(isset($args['name']))
            {$this->name        = $args['name'];}

        if(isset($args['quality']))
            {$this->quality     = $args['quality'];}

        if(isset($args['description']))
            {$this->description = $args['description'];}
    }

    public function Describe()
    {
        return new Response('override', 'A ' . $this->name . ' of ' . self::$qualityMap[$this->quality] . ' quality. ' . $this->description);
    }

    public static function LoadItems()
    {
        $items = Database::Query('SELECT * FROM RPGBot.items;');
        for($i = 0; $i < count($items); $i++)
            {array_push(self::$allItems, new Item($item[$i]));}
    }
}
?>