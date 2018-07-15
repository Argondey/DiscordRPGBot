<?php
class MeCommand extends Command
{
    public function HandleCommand()
    {
        $comm = $this->Pop();
        if(!is_string($comm))
            {return new DirectResponse($this->user->name . '- You did not ask me to do anything');}

        switch(strtolower($comm))
        {
            case 'items':
                return $this->user->inventory->List();
            case 'name':
                return new DirectResponse('I know you as ' . $this->user->name);
            default:
                return new Confusion();
        }
    }
}
?>