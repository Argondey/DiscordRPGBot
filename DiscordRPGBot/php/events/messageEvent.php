<?php
class MessageEvent
{
    public static function HandleEvent(\CharlotteDunois\Yasmin\Models\Message $message)
    {
        if(!$message->author->bot)
        {
            $guild = Guild::GetGuild($message->guild);
            if($guild != null){Logger::Log('Guild Found.');}

            $user = self::IdentifyUser($message);
            if($user != null)
            {
                Logger::Log('User found.');
                if(substr($message->content, 0, 1) == $guild->settings['commandPrefix'])
                {
                    $content = explode(' ', substr(strtolower($message->content), 1));
                    $command = array_shift($content);
                    switch($command)
                    {
                        case 'hello':
                            Logger::Log('Message event: Greeting');
                            return new Greeting();    
                        case 'guild':
                            Logger::Log('Guild Command');
                            $guildCommand = new GuildCommand($user, $content);
                            return $guildCommand->HandleCommand();
                        case 'item':
                            Logger::Log('Item Command');
                            $itemCommand = new ItemCommand($user, $content);
                            return $itemCommand->HandleCommand();
                        case 'loot':
                            Logger::Log('Loot Command');
                            $loot = new Loot();
                            $result = $loot->GetLoot($user);
                            if(is_a($result, 'Item'))
                                {return $result->Describe();}
                            else{return $result;}
                        case 'myinventory':
                            return $user->inventory->List();
                        default:
                            Logger::Log('Message Event: Confusion');
                            return new Confusion();
                    }
                }
            }
        }
    }

    public static function IdentifyUser(\CharlotteDunois\Yasmin\Models\Message $message)
    {
        if($message->guild == null)
        {
            $message->channel->send('I\'m sorry I cant talk right now, catch me later when im at your Guild.');
            return null;
        }
        else
        {
            $guild = Guild::GetGuild($message->guild);
            return $guild->GetUser($message->author);
        }
    }
}
?>