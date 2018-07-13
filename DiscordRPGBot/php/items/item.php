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
        $this->activeEffects    = $args['activeEffects'];
        $this->passiveEffects   = $args['passiveEffects'];
        $this->slot             = $args['slot'];

        $this->uses             = $args['maxUses'];
    }

    public function Describe()
    {
        return new Response('override', 'A(n) ' . $this->name . ' of ' . $this->quality . ' quality. ' . $this->description);
    }

    public function Info()
    {
        $info = 
            ['Name: '       . $this->name
            ,'Type: '       . $this->type
            ,'Quality: '    . $this->quality
            ,'Uses: '       . $this->uses . '/' . $this->maxUses
            ,'Slot: '       . $this->slot];

        if(isset($this->activeEffects) && count($this->activeEffects) > 0)
            {array_push($info, 'Active Effects: ' . implode(', ', $this->activeEffects));}

        if(isset($this->passiveEffects) && count($this->passiveEffects) > 0)
            {array_push($info, 'Passive Effects: ' . implode(', ', $this->passiveEffects));}

        return new Response('override', implode("\r\n", $info));
    }

    public function Use($target)
    {

    }
}
?>