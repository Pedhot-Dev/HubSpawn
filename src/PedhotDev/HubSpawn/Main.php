<?php

namespace PedhotDev\HubSpawn;

use PedhotDev\HubSpawn\commands\AdminCommand;
use PedhotDev\HubSpawn\commands\HubCommand;
use PedhotDev\HubSpawn\commands\SpawnCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\Position;
use Exception;
use pocketmine\world\World;

class Main extends PluginBase
{
    use SingletonTrait;

    private Config $data;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        $this->data = new Config($this->getDataFolder() . "data.yml");
        Server::getInstance()->getCommandMap()->registerAll($this->getName(), [
            new HubCommand($this),
            new SpawnCommand($this),
            new AdminCommand($this),
        ]);
    }

    protected function onDisable(): void
    {
        try {
            $this->data->save();
        }catch (Exception){}
    }

    public function getHub(): Position {
        $data = $this->data->get("hub");
        $world = ($worldManager = Server::getInstance()->getWorldManager())->getWorldByName(($data["world"] ?? "world")) ?? $worldManager->getDefaultWorld();
        return new Position((int)($data["x"] ?? 0), (int)($data["y"] ?? 0), (int)($data["z"] ?? 0), $world);
    }

    public function getSpawnPoint(World|string $world): Position {
        if (is_string($world)) {
            $world = Server::getInstance()->getWorldManager()->getWorldByName($world);
        }
        return $world->getSpawnLocation();
    }

    public function setHub(Position $position): bool {
        $this->data->set("hub", [
            "x" => floor($position->getX()),
            "y" => floor($position->getY()),
            "z" => floor($position->getZ()),
            "world" => floor($position->getWorld()->getFolderName()),
        ]);
        return true;
    }

    public function setSpawnPoint(Position $position): bool {
        $position->getWorld()->setSpawnLocation($position->asVector3());
        return true;
    }

}