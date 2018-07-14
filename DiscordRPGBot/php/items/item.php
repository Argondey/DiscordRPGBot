<?php
class Item extends ItemBase
{
    public $id              = 0;
    public $name            = '';
    public $type            = 0;
    public $quality         = 0;
    public $description     = '';
    public $maxUses         = -1;
    public $activeEffects   = [];
    public $passiveEffects  = [];
    public $value           = 0;
    public $slot            = [];

    public $uses            = 0;
    public $quantity        = 1;

    public function __construct(array $args)
    {
        $this->id               = $args['id'];
        $this->name             = $args['name'];
        $this->type             = $args['type'];
        $this->quality          = $args['quality'];
        $this->description      = $args['description'];
        $this->maxUses          = $args['maxUses'];
        $this->activeEffects    = explode(', ', $args['activeEffects']);
        $this->passiveEffects   = explode(', ', $args['passiveEffects']);
        $this->value            = $args['value'];
        $this->slot             = $args['slot'];

        $this->uses             = $args['maxUses'];
    }

    public function __get($var)
    {
        switch($var)
        {
            default:
                return $this->$var;
            //return percentage value remaining if less that max uses are available
            case 'value':
                return $this->value * ($this->uses / $this->maxUses);
        }
    }

    public function Describe()
    {
        return new Response('override', 'A(n) ' . $this->name . ' of ' . Item::QUALITIES[$this->quality] . ' quality. ' . $this->description);
    }

    public function Info()
    {
        $info = 
            ['Name: '       . $this->name
            ,'Type: '       . $this->type
            ,'Quality: '    . Item::QUALITIES[$this->quality]
            ,'Slot: '       . $this->slot];

        if($this->uses !== -1)
        {
            if($this->uses == $this->maxUses)
                {array_push($info, 'Uses: ' . $this->maxUses);}
            else{array_push($info, 'Uses: ' . $this->uses . '/' . $this->maxUses);}
        }

        if(isset($this->activeEffects) && count($this->activeEffects) > 0)
            {array_push($info, 'Active Effects: ' . implode(', ', $this->activeEffects));}

        if(isset($this->passiveEffects) && count($this->passiveEffects) > 0)
            {array_push($info, 'Passive Effects: ' . implode(', ', $this->passiveEffects));}

        return new Response('override', implode("\r\n", $info), true);
    }

    public function Use($target)
    {

    }
}
?>