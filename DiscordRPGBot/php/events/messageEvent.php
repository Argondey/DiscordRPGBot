<?php
class MessageEvent
{
    public static function HandleEvent(\CharlotteDunois\Yasmin\Models\Message $message)
    {
        if(!$message->author->bot)
        {
            $guild = Guild::GetGuild($message->guild);
            if($guild != null){Logger::Log('A guild was found.');}

            $user = self::IdentifyUser($message);
            if($user != null)
            {
                Logger::Log('A user was found.');
                if(substr($message->content, 0, 1) == $guild->settings['commandPrefix'])
                {
                    $content = explode(' ', substr(strtolower($message->content), 1));
                    switch($content[0])
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
                        case 'item':
                            if(count($content) > 1)
                            {
                                switch($content[1])
                                {
                                    case 'discard':
                                        if(count($content) > 2)
                                        {
                                            $numToDiscard = 1;
                                            if(count($content) > 3 && is_int($content[3]))
                                                {$numToDiscard = $content[3];}

                                            $numDiscarded = $user->inventory->DiscardItem($content[2], $numToDiscard);
                                            if($numDiscarded !== false)
                                                {return new Response('override', $user->name . ' has discarded '        . $content[2] . ' X' . $numDiscarded . '.');}
                                            else{return new Response('override', $user->name . ' did not have a(n) '    . $content[2] . ' to discard.');}
                                        }
                                        else{return new Response('override', $user->name . '- You did not specify which item to discard.');}
                                        break;
                                    case 'info':
                                        if(count($content > 1))
                                            {return Item::Find($content[2]);}
                                        else{return new Response('override', $user->name . '- You did not specify which item to get info on.');}
                                        break;
                                    case 'Use':
                                        break;
                                }  
                            }
                            break;
                        case 'loot':
                            $loot = new Loot();
                            $result = $loot->GetLoot($user);
                            if(is_a($result, 'Item'))
                                {return $result->Describe();}
                            else{return $result;}
                            break;
                        case 'myinventory':
                            return $user->inventory->ListItems();
                            break;
                        default:
                            Logger::Log('Message event resovled as Confusion');
                            return new Confusion();
                            break;
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