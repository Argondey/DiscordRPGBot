<?php
class Command
{
    public $user = null;
    public $command = [];

    public function __construct(User $user, array $command)
    {
        $this->user     = $user;
        $this->command  = $command;

        Logger::Log(get_called_class() . ' was created');
    }

    Public function Pop()
    {return array_shift($this->command);}
}
?>