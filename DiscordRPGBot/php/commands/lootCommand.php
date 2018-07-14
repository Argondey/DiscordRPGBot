<?php
class LootCommand extends Command
{
    public function HandleCommand()
    {
        $comm = $this->Pop();
        if(!is_string($comm))
            {return new Response('override', $this->user->name . '- You did not ask me to do anything');}

        switch(strtolower($comm))
        {
            case 'get':
                $loot = new Loot();
                $result = $loot->GetLoot($user);
                if(is_a($result, 'Item'))
                    {return $result->Describe();}
                else{return $result;}
            default:
                return new Confusion();
        }
    }
}
?>