<?php
class GuildCommand extends Command
{
    public function HandleCommand()
    {
        $comm = $this->Pop();
        if(!is_string($comm))
        {
            Logger::Log('Guild Command: Unknown Command');
            return new Response('override', $this->user->name . '- You did not ask me to do anything');
        }

        switch(strtolower($comm))
        {
            case 'search':
                Logger::Log('Guild Command: Search');
                return $this->user->guild->inventory->List();
                break;
            case 'setting':
                Logger::Log('Guild Command: Setting');
                $name   = $this->Pop();
                $value  = $this->Pop();
                if($name == null || $value == null)
                {
                    return new Response('override'
                        ,$this->user->name 
                            . '- $guild setting is used to set the value of a guild-wide setting.'
                            . "\r\n" . 'The proper format is $guild setting [settingName] [newValue]'
                            . "\r\n" . ' The setting name options are: ' 
                            . implode(', ', array_keys($this->user->guild->settings)));
                }
                else
                {
                    //todo- actually validate the ne value
                    $this->user->guild->settings[$name] = $value;
                    return new Response('override'
                        ,$this->user->name 
                            . '- Guild setting ' . $name . ' has been set to ' . $value);
                }
                break;
            default:
                return new Confusion();
        }
    }
}