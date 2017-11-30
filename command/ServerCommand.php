<?php

namespace Raid\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Raid\Core;
use Raid\lang\TextContainer;

class ServerCommand extends Command
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Get server address"
        );
        $this->setPermission("raid.command.server.name");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)) return true;
        $sender->sendMessage(Core::getInstance()->getLanguage()->translate(new TextContainer('commands.server.name')));
        return true;
    }
}