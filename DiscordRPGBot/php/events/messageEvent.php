<?php
class MessageEvent
{
    public static function HandleEvent(\CharlotteDunois\Yasmin\Models\Message $message)
    {
        $guild  = Guild::GetGuild($message->guild);
        if($guild != null){Logger::Log('A guild was found.');}

        $user = self::IdentifyUser($message);
        if($user != null)
        {
            Logger::Log('A user was found.');
            if(substr($message->content, 0, 1) == $guild->settings['commandPrefix'])
            {
                $content = explode(' ', substr($message->content, 1));
                switch(strtolower($content[0]))
                {
                    case'hello':
                        Logger::Log('Message event resovled as Greeting');
                        return new Greeting();
                        break;             
                    case'changeprefix':
                        Logger::Log('Message event resovled as ChangePrefix');
                        $len = strlen($content[1]);
                        if($len == 1)
                        {
                            $guild->settings['commandPrefix'] = $content[1];
                            $message->channel->send('Prefix changed to ' . $content[1]);
                            Logger::Log('Prefix changed to ' . $content[1]);
                        }
                        else if($len == 0)
                        {
                            $message->channel->send('No replacement prefix was sent');
                            Logger::Log('No replacement prefix was sent');
                        }
                        else
                        {
                            $message->channel->send('New prefix was more than 1 character! Only 1 character prefixes are allowed.');
                            Logger::Log('New prefix was more than 1 character! Only 1 character prefixes are allowed.');
                        }
                        break;
                    case 'giveloot':
                        $loot = new Loot();
                        $item = $loot->GetLoot();
                        $user->AddItem($item);
                        return $item->Describe();
                        break;
                    case 'myinventory':
                        return $user->ListInventory();
                        break;
                    default:
                        Logger::Log('Message event resovled as Confusion');
                        return new Confusion();
                        break;
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