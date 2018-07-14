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
            case 'describe':
                $item = Item::Find($itemName);
                if($item !== false)
                    {return $item->Describe();}
                else{return new Response('override', $this->user->name . '- That item does not exist!');}
            case 'destroy':
                $numDestroyed = $this->user->inventory->Discard($itemName, ...$this->command);
                if($numDestroyed !== false)
                    {return new Response('override', $this->user->name . ' has destroyed ' . $itemName . ' x' . $numDestroyed . '. It seems wasteful...');}
                else{return new Response('override', $this->user->name . ' did not have a(n) ' . $itemName . ' to destroy');}
                break;
            case 'discard':
                $numDiscarded = $this->user->inventory->Discard($itemName, ...$this->command);
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
                        {return new Response('override', $this->user->name . ' used ' . $itemName . ' on ' . $target->name);}
                    else{return new Response('override', $this->user->name . ' did not have a(n) ' . $itemName . ' to use on ' . $target->name);}
                }
                break;
            case 'grab':
                $item = $user->guild->inventory->Retrieve($itemName, ...$this->command);
                if($item != null)
                {
                    $user->inventory->Add($item);
                    return new Response('override', $this->user->name . ' found ' . $itemName . ' just sitting on the Guild Floor! Who would just throw that away?');
                }
                else{return new Response('override', $this->user->name . ' went scrounging for a(n) ' . $itemName . ' on the Guild Floor, but there were none to be had');}
            default:
                return new Confusion();
        }
    }
}
?>