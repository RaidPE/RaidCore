<?php

namespace Raid\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Raid\Core;

class VersionCommand extends Command
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Get the version of this server", null,
            ['ver', 'about']
        );
        $this->setPermission("raid.command.server.version");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)) return true;
        $sender->sendMessage("RaidPE servers are running PocketMine.\nServer version: " . $sender->getServer()->getVersion() . "(API: " . $sender->getServer()->getApiVersion() . ")\nCore version: " . Core::getInstance()->getCoreVersion() . "\nServer name: " . Core::getInstance()->getServerName());
        if($sender instanceof Player) $sender->addTitle('RaidPE', 'Thanks for playing!');
        return true;
    }
}