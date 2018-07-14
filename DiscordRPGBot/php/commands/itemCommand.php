<?php
class ItemCommand extends Command
{
    public function HandleCommand(user $user, array $command)
    {
        $comm = $this->Pop();
        if(!is_a($comm, 'string'))
            {return new Response('override', $user->name . '- You did not ask me to do anything');}
        
        $itemName = $this->Pop();
        if(!is_a($itemName, 'string'))
            {return new Response('override', $user->name . '- You did not specify an item');}

        switch($comm)
        {
            case 'destroy':
                $numDestroyed = $user->inventory->DiscardItem($itemName, ...$command);
                if($numDestroyed !== false)
                    {return new Response('override', $user->name . ' has destroyed '        . $itemName . ' x' . $numDestroyed . '. It seems wasteful...');}
                else{return new Response('override', $user->name . ' did not have a(n) '    . $itemName . ' to destroy');}
                break;
            case 'discard':
                $numDiscarded = $user->inventory->DiscardItem($itemName, ...$command);
                if($numDiscarded !== false)
                    {return new Response('override', $user->name . ' has discarded '        . $itemName . ' x' . $numDiscarded . '.');}
                else{return new Response('override', $user->name . ' did not have a(n) '    . $itemName . ' to discard');}
                break;
            case 'info':
                return Item::Find($itemName)->Info();
                break;
            case 'Use':
                $target = $user->guild->FindUser($this->Pop());
                if($target != null)
                {
                    if($user->inventory->Use($itemName, $target))
                        {return new Response('override', $user->name . ' used '    . $itemName . ' on ' . $target->name);}
                    else{return new Response('override', $user->name . ' did not have a(n) '    . $itemName . ' to use on ' . $target->name);}
                }
                break;
            default:
                return new Confusion();
        }
    }
}
?>