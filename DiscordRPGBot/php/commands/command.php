<?php
class Command
{
    public $user = null;
    public $command = [];

    public function __construct(User $user, array $command)
    {
        $this->user     = $user;
        $this->command  = $command;
    }

    Public function Pop()
    {return array_shift($this->command);}
}
?>