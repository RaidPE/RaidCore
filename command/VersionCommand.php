<?php

namespace Raid\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Raid\Core;
use Raid\lang\TextContainer;
use Raid\lang\TranslationContainer;

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
        $sender->sendMessage(Core::getInstance()->getLanguage()->translate(new TranslationContainer('commands.version', [
            $sender->getServer()->getVersion(),
            $sender->getServer()->getApiVersion(),
            Core::getInstance()->getCoreVersion(),
            Core::getInstance()->getServerName(),
            Core::getInstance()->getServerArea()
        ])));
        if($sender instanceof Player)
            $sender->addTitle('RaidPE', Core::getInstance()->getLanguage()->translate(new TextContainer('commands.version.title')));
        return true;
    }
}