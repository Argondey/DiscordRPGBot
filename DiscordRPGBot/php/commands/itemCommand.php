<?php
class ItemCommand extends Command
{
    public function HandleCommand()
    {
        $comm = $this->Pop();
        if(!is_string($comm))
            {return new DirectResponse($this->user->name . '- You did not ask me to do anything');}
        
        $itemName = $this->Pop();
        if(!is_string($itemName))
        {
            if($comm === 'unequip')
                {return new DirectResponse($this->user->name . '- You did not specify a gear slot');}
            else{return new DirectResponse($this->user->name . '- You did not specify an item');}
        }

        switch(strtolower($comm))
        {
            case 'describe' :
                $item = Item::Find($itemName);
                if($item !== false)
                    {return $item->Describe();}
                else{return new DirectResponse($this->user->name . '- That item does not exist!');}
            case 'destroy'  :
                $numDestroyed = $this->user->inventory->Discard($itemName, ...$this->command);
                if($numDestroyed !== false)
                    {return new DirectResponse($this->user->name . ' has destroyed ' . $itemName . ' x' . $numDestroyed . '. It seems wasteful...');}
                else{return new DirectResponse($this->user->name . ' did not have a(n) ' . $itemName . ' to destroy');}
                break;
            case 'equip'    :
                if($this->user->character != null)
                {
                    $item = $this->user->inventory->Retrieve($itemName);
                    if($item !== null)
                    {
                        if($this->user->inventory->Equip($item))
                            {return new DirectResponse($this->user->name . ' has equipped ' . $itemName . ' to their ' . $item->slot . ' slot');}
                        else
                        {
                            $this->user->inventory->Add($item);
                            return new DirectResponse($this->user->name . ' could not equip ' . $itemName . ' since it does not occupy a gear slot');
                        }
                    }
                    else{return new DirectResponse($this->user->name . ' did not have a(n) '    . $itemName . ' to equip');}
                }
                else{return new DirectResponse($this->user->name . '- You don\'t have a character to equip items to!');}
            case 'unequip'  :
                if($this->user->character != null)
                {
                    if($this->user->inventory->UnEquip($itemName))
                        {return new DirectResponse($this->user->name . ' has unequipped the item in their ' . $itemName . ' slot');}
                    else
                    {
                        return new DirectResponse($this->user->name . ' could not unequip their ' . $itemName . ' slot as they did not anything equipped there');
                    }
                }
                else{return new DirectResponse($this->user->name . '- You don\'t have a character to unequip items from!');}
            case 'discard'  :
                $numDiscarded = $this->user->inventory->Discard($itemName, ...$this->command);
                if($numDiscarded !== false)
                    {return new DirectResponse($this->user->name . ' has discarded '        . $itemName . ' x' . $numDiscarded . '.');}
                else{return new DirectResponse($this->user->name . ' did not have a(n) '    . $itemName . ' to discard');}
                break;
            case 'info'     :
                return Item::Find($itemName)->Info();
                break;
            case 'use'      :
                $target = $this->user->guild->FindUser($this->Pop());
                if($target != null)
                {
                    if($this->user->inventory->Use($itemName, $target))
                        {return new DirectResponse($this->user->name . ' used ' . $itemName . ' on ' . $target->name);}
                    else{return new DirectResponse($this->user->name . ' did not have a(n) ' . $itemName . ' to use on ' . $target->name);}
                }
                else{return new DirectResponse($this->user->name . '- You did not say who to use the item on');}
                break;
            case 'grab'     :
                $item = $this->user->guild->inventory->Retrieve($itemName, ...$this->command);
                if($item != null)
                {
                    $this->user->inventory->Add($item);
                    return new DirectResponse($this->user->name . ' found ' . $itemName . ' just sitting on the Guild Floor! Who would just throw that away?');
                }
                else{return new DirectResponse($this->user->name . ' went scrounging for a(n) ' . $itemName . ' on the Guild Floor, but there were none to be had');}
            default:
                return new Confusion();
        }
    }
}
?>