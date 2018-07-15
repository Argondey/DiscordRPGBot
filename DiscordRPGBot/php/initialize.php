<?php
require_once 'config.php';
require_once 'logger.php';
require_once 'database.php';

require_once 'entities/entity.php';
require_once 'entities/guild.php';
require_once 'entities/user.php';

require_once 'characters/character.php';
require_once 'characters/roles/role.php';
require_once 'characters/roles/fighter.php';
require_once 'characters/roles/mage.php';
require_once 'characters/roles/thief.php';
require_once 'characters/roles/roleSelect.php';

require_once 'commands/command.php';
require_once 'commands/characterCommand.php';
require_once 'commands/itemCommand.php';
require_once 'commands/guildCommand.php';
require_once 'commands/lootCommand.php';
require_once 'commands/meCommand.php';

require_once 'items/itemBase.php';
require_once 'items/item.php';
require_once 'items/inventory.php';
require_once 'items/userInventory.php';
require_once 'items/guildInventory.php';
require_once 'items/loot.php';

require_once 'events/messageEvent.php';
require_once 'events/eventHandler.php';

require_once 'responses/response.php';
require_once 'responses/directResponse.php';
require_once 'responses/generatedResponse.php';
require_once 'responses/randomResponse.php';
require_once 'responses/greeting.php';
require_once 'responses/confusion.php';

$config = new Config();

Item::LoadItems();

$eventHandler = new EventHandler($config::$eventLoop, $config::$yasmin);
?>