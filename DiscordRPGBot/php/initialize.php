<?php

require_once 'config.php';
require_once 'logger.php';
require_once 'database.php';

require_once 'items/itemBase.php';
require_once 'items/item.php';
require_once 'items/inventory.php';
require_once 'items/loot.php';

require_once 'players/guild.php';
require_once 'players/user.php';

require_once 'events/messageEvent.php';
require_once 'events/eventHandler.php';

require_once 'responses/response.php';
require_once 'responses/greeting.php';
require_once 'responses/confusion.php';

$config = new Config();

Item::LoadItems();

$eventHandler = new EventHandler($config::$eventLoop, $config::$yasmin);
?>