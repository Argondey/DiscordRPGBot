<?php
class ItemCommand extends Command
{
    public function HandleCommand()
    {
        $comm = $this->Pop();
        if(!is_string($comm))
            {return new Response('override', $this->user->name . '- You did not ask me to do anything');}
        
        $itemName = $this->Pop();
        if(!is_string($itemName))
            {return new Response('override', $this->user->name . '- You did not specify an item');}

        switch($comm)
        {
            case 'destroy':
                $numDestroyed = $this->user->inventory->DiscardItem($itemName, ...$this->command);
                if($numDestroyed !== false)
                    {return new Response('override', $this->user->name . ' has destroyed '        . $itemName . ' x' . $numDestroyed . '. It seems wasteful...');}
                else{return new Response('override', $this->user->name . ' did not have a(n) '    . $itemName . ' to destroy');}
                break;
            case 'discard':
                $numDiscarded = $this->user->inventory->DiscardItem($itemName, ...$this->command);
                if($numDiscarded !== false)
                    {return new Response('override', $this->user->name . ' has discarded '        . $itemName . ' x' . $numDiscarded . '.');}
                else{return new Response('override', $this->user->name . ' did not have a(n) '    . $itemName . ' to discard');}
                break;
            case 'info':
                return Item::Find($itemName)->Info();
                break;
            case 'use':
                $target = $this->user->guild->FindUser($this->Pop());
                if($target != null)
                {
                    if($this->user->inventory->Use($itemName, $target))
                        {return new Response('override', $this->user->name . ' used '    . $itemName . ' on ' . $target->name);}
                    else{return new Response('override', $this->user->name . ' did not have a(n) '    . $itemName . ' to use on ' . $target->name);}
                }
                break;
            default:
                return new Confusion();
        }
    }
}
?>