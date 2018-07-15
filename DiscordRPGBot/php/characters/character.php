<?php
class character 
{
    public $user            = null;
    public $role            = null;

    public $strength        = 1;
    public $intelligence    = 1;
    public $dexterity       = 1;
    public $charisma        = 1;
    public $luck            = 1;
    public $relationship    = 1;

    public $currentHealth   = 1;
    public $maxHealth       = 1;

    public $level           = 1;
    public $xp              = 0;

    public function __construct(User $user, Role $role)
    {
        $this->user                 = $user;
        $this->user->lastNewChar    = time();
        $this->role                 = $role;
        $this->GenerateStats();
    }

    public function GainXp(int $amount = 0)
    {
        $this->xp += $amount;
    }

    public function GenerateStats()
    {
        $this->strength     = random_int(0, 6) + $this->role->strengthAdjustment;
        $this->intelligence = random_int(0, 6) + $this->role->intelligenceAdjustment;
        $this->dexterity    = random_int(0, 6) + $this->role->dexterityAdjustment;
        $this->charisma     = random_int(0, 6) + $this->role->charismaAdjustment;
        $this->luck         = random_int(0, 6) + $this->role->luckAdjustment;
        $this->relationship = random_int(0, 6) + $this->role->relationshipAdjustment;
        $this->HankAdjustment();

        $this->maxHealth        = ($this->strength * 2) + $this->luck;
        $this->currentHealth    = $this->maxHealth;
    }

    //For my good friend Hank, who is a good guy.
    public function HankAdjustment()
    {
        if($this->user->name === 'Hank' && $this->user->discriminator === '0344')
        {
            $this->luck     -= 3;
            $this->charisma += 3;
        }
    }

    public function Info()
    {
        $info = 
            ['Role: '           . get_class($this->role)
            ,'Stength: '        . $this->strength
            ,'Intelligence: '   . $this->intelligence
            ,'Dexterity: '      . $this->dexterity
            ,'Charisma: '       . $this->charisma
            ,'Luck: '           . $this->luck
            ,'Relationship: '   . $this->relationship
            ,'Health: '         . $this->currentHealth . '/' . $this->maxHealth
            ,'Level: '          . $this->level
            ,'XP: '             . $this->xp];
        return new DirectResponse(implode("\r\n", $info), true);
    }
}
?>