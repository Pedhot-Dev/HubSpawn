<?php

namespace PedhotDev\HubSpawn\commands;

use PedhotDev\HubSpawn\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class AdminCommand extends Command
{

    public function __construct(private Main $plugin)
    {
        parent::__construct("hubspawn", "Set or edit server hub & world spawn point", "/hubspawn <option>");
        $this->setPermission("hubspawn.command.admin");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) return;
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "You can only execute this command as a player!");
            return;
        }
        if (empty($args[0])) {
            $sender->sendMessage($this->getUsage());
            return;
        }
        switch ($args[0]) {
            case "hub":
                $this->plugin->setHub($sender->getPosition());
                $sender->sendMessage(TextFormat::GREEN . "Set hub position successfully");
                break;
            case "spawn":
                $this->plugin->setSpawnPoint($sender->getPosition());
                $sender->sendMessage(TextFormat::GREEN . "Set world spawn point successfully");
                break;
            default:
                $sender->sendMessage(TextFormat::RED . "Available option is: hub, spawn");
        }
    }

}