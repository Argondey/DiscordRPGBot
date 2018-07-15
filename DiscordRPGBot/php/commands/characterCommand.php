<?php
class characterCommand extends Command
{
    public function HandleCommand()
    {
        $comm = $this->Pop();
        if(!is_string($comm))
            {return new DirectResponse($this->user->name . '- You did not ask me to do anything');}

        switch(strtolower($comm))
        {
            case 'create':
                if($this->user->character === null)
                {
                    $roleName = $this->Pop();
                    if($roleName != null)
                    {
                        $role = RoleSelect::GetRole($roleName);
                        if($role != null)
                        {
                            $timeSinceLastChar = time() - $this->user->lastNewChar;
                            $charCooldown = $this->user->guild->settings['createCharCooldown'] * 60;
                            if($timeSinceLastChar > $charCooldown)
                            {
                                $this->user->character = new Character($this->user, $role);
                                return $this->user->character->Info();
                            }
                            else return new DirectResponse('You cannot create a new character yet. You can create one again in ' . ($charCooldown - $timeSinceLastChar) . ' seconds.');
                        }
                        else{return new DirectResponse($this->user->name . '- The role you specified does not exist.');}
                    }
                    else{return new DirectResponse($this->user->name . '- You did not specify which role you want your new character to use. Proper format is @char create [Role].');}
                }
                else{return new DirectResponse($this->user->name . '- You cannot create a new character as you have an existing character already, call @char delete if you want to get rid of it.');}
            case 'delete':
                if($this->user->character !== null)
                {
                    $this->user->character = null;
                    return new DirectResponse($this->user->name . '- You have killed your character. I hope you are happy.');
                }
                else{return new DirectResponse($this->user->name . '- You don\'t have a character to kill, probably because you killed your last one too.');}
            default:
                return new Confusion();
        }
    }
}
?>