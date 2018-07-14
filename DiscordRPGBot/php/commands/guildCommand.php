<?php
class GuildCommand extends Command
{
    public function HandleCommand()
    {
        $comm = $this->Pop();
        if(!is_string($comm))
            {return new Response('override', $this->user->name . '- You did not ask me to do anything');}

        switch($comm)
        {
            case 'floor':
                return $user->guild->inventory->ListItems();
                break;
            default:
                return new Confusion();
    }
}