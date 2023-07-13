# HubSpawn
Hub & Spawn for PocketMine-MP V5

# Features
- Set server hub/lobby
- Set world spawn point
- Teleport to server hub/lobby
- Teleport to world spawn point
- With permission (default/OP)

# Commands & Permissions
| Commands  | Permissions            | Informations |
| ------------- |------------------------| ------------- |
| /hubspawn  | hubspawn.command.admin | Admin only  |
| /hub  | hubspawn.command.hub           | For all players  |
| /spawn  | hubspawn.command.spawn         | For all players  |

# API
### Get server hub / lobby & world spawn point
```php
use PedhotDev\HubSpawn\Main;

// Hub/Lobby
Main::getInstance()->getHub();

// World spawn point
Main::getInstance()->getSpawnPoint("World Name")
```
### Ser server hub / lobby & world spawn point
```php
use PedhotDev\HubSpawn\Main;

// Hub/Lobby
Main::getInstance()->setHub($position);

// World spawn point
Main::getInstance()->setSpawnPoint($position);
```