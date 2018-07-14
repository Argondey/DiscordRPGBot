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

        switch($comm)
        {
            case 'floor':
                Logger::Log('Guild Command: Floor');
                return $this->user->guild->inventory->ListItems();
                break;
            case'changeprefix':
                Logger::Log('Guild Command: ChangePrefix');
                $command    = $this->Pop();
                $len        = strlen($command);
                if($len == 1)
                {
                    $guild->settings['commandPrefix'] = $command;
                    $message->channel->send('Prefix changed to ' . $command);
                    Logger::Log('Prefix changed to ' . $command);
                }
                else if($len == 0)
                {
                    $message->channel->send('No replacement prefix was sent');
                    Logger::Log('No replacement prefix sent');
                }
                else
                {
                    $message->channel->send('New prefix was more than 1 character! Only 1 character prefixes are allowed');
                    Logger::Log('New prefix Rejected for length');
                }
                break;
            default:
                return new Confusion();
        }
    }
}