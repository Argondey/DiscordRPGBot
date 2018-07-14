<?php

require_once 'config.php';
require_once 'logger.php';
require_once 'database.php';

require_once 'commands/command.php';
require_once 'commands/itemCommand.php';

require_once 'items/itemBase.php';
require_once 'items/item.php';
require_once 'items/inventory.php';
require_once 'items/userInventory.php';
require_once 'items/guildInventory.php';
require_once 'items/loot.php';

require_once 'entities/entity.php';
require_once 'entities/guild.php';
require_once 'entities/user.php';

require_once 'events/messageEvent.php';
require_once 'events/eventHandler.php';

require_once 'responses/response.php';
require_once 'responses/greeting.php';
require_once 'responses/confusion.php';

$config = new Config();

Item::LoadItems();

$eventHandler = new EventHandler($config::$eventLoop, $config::$yasmin);
?>