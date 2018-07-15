<?php
class LootCommand extends Command
{
    public function HandleCommand()
    {
        $comm = $this->Pop();
        if(!is_string($comm))
            {return new DirectResponse($this->user->name . '- You did not ask me to do anything');}

        switch(strtolower($comm))
        {
            case 'item':
                $loot = new Loot();
                $result = $loot->GetLoot($this->user);
                if(is_a($result, 'Item'))
                    {return $result->Describe();}
                else{return $result;}
            default:
                return new Confusion();
        }
    }
}
?>