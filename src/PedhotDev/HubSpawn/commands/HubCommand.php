<?php

namespace PedhotDev\HubSpawn\commands;

use PedhotDev\HubSpawn\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HubCommand extends Command
{

    public function __construct(private Main $plugin)
    {
        parent::__construct("hub", "Teleport into server hub", null, ["lobby"]);
        $this->setPermission("hubspawn.command.hub");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) return;
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "You can only execute this command as a player!");
            return;
        }
        $hub = $this->plugin->getHub();
        if (!$hub->getWorld()->isLoaded()) {
            $sender->sendMessage(TextFormat::RED . "Hub world currently not loaded!");
            return;
        }
        if ($hub->getWorld()->isChunkLoaded($hub->getX(), $hub->getZ())) {
            $hub->getWorld()->loadChunk($hub->getX(), $hub->getZ());
        }
        $sender->teleport($this->plugin->getHub());
        $sender->sendMessage(TextFormat::GREEN . "Success teleport into server lobby/hub");
    }

}