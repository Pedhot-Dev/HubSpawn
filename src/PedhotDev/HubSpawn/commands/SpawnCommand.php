<?php

namespace PedhotDev\HubSpawn\commands;

use PedhotDev\HubSpawn\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class SpawnCommand extends Command
{

    public function __construct(private Main $plugin)
    {
        parent::__construct("spawn", "Teleport into world spawn point");
        $this->setPermission("hubspawn.command.spawn");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) return;
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "You can only execute this command as a player!");
            return;
        }
        $spawn = $this->plugin->getSpawnPoint($sender->getWorld());
        if ($spawn->getWorld()->isChunkLoaded($spawn->getX(), $spawn->getZ())) {
            $spawn->getWorld()->loadChunk($spawn->getX(), $spawn->getZ());
        }
        $sender->teleport($this->plugin->getHub());
        $sender->sendMessage(TextFormat::GREEN . "Success teleport into world spawn point");
    }

}