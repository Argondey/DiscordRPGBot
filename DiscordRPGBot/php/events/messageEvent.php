<?php
class MessageEvent
{
    public static function HandleEvent(\CharlotteDunois\Yasmin\Models\Message $message)
    {
        if(!$message->author->bot)
        {
            $guild  = Guild::GetGuild($message->guild);
            $user   = self::IdentifyUser($message);
            if($user != null)
            {
                if(substr($message->content, 0, 1) == $guild->settings['commandPrefix'])
                {
                    $content = explode(' ', substr($message->content, 1));
                    $command = array_shift($content);
                    switch(strtolower($command))
                    {
                        case 'hello':
                            return new Greeting();    
                        case 'char':
                            $charCommand = new CharacterCommand($user, $content);
                            return $charCommand->HandleCommand();
                        case 'guild':
                            $guildCommand = new GuildCommand($user, $content);
                            return $guildCommand->HandleCommand();
                        case 'item':
                            $itemCommand = new ItemCommand($user, $content);
                            return $itemCommand->HandleCommand();
                        case 'loot':
                            $lootCommand = new LootCommand($user, $content);
                            return $lootCommand->HandleCommand();
                        case 'me':
                            $meCommand = new MeCommand($user, $content);
                            return $meCommand->HandleCommand();
                        default:
                            return  new DirectResponse($user->name 
                                . '- The possible top level commands are: hello, guild, item, loot, me'
                                . "\r\n" . 'The proper format is [prefix][command]'
                                . "\r\n" . 'Note: Most top level commands must be followed by a sub-command and/or parameters');
                    }
                }
            }
        }
    }

    public static function IdentifyUser(\CharlotteDunois\Yasmin\Models\Message $message)
    {
        if($message->guild == null)
        {
            Logger::Log('Out of Guild message.');
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