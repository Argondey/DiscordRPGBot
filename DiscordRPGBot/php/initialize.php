<?php

require_once 'config.php';
require_once 'logger.php';
require_once 'database.php';
require_once 'items/item.php';
require_once 'items/loot.php';
require_once 'items/weapons/hammer.php';
require_once 'items/weapons/pistol.php';
require_once 'items/weapons/rapier.php';
require_once 'items/weapons/shield.php';
require_once 'items/weapons/sword.php';
require_once 'events/messageEvent.php';
require_once 'eventHandler.php';
require_once 'response.php';
require_once 'responses/greeting.php';
require_once 'responses/confusion.php';

$config = new Config();


$items = Database::Query('SELECT * FROM RPGBot.items;');
var_dump($items);

$eventHandler = new EventHandler($config::$eventLoop, $config::$yasmin);

$eventHandler->Event();
?>