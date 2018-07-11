<?php

require_once 'config.php';
require_once 'eventHandler.php';
require_once 'response.php';
require_once 'responses/greeting.php';
require_once 'responses/confusion.php';

$config = new Config();

$eventHandler = new EventHandler($config::$eventLoop, $config::$yasmin);

$eventHandler->Event();
?>