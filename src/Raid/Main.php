<?php

namespace Raid;

use pocketmine\plugin\PluginBase;
use Raid\command\ServerCommand;

class Main extends PluginBase
{
    public function onLoad()
    {
        new Core($this->getServer());
        $this->registerCoreCommands();
    }

    private function registerCoreCommands()
    {
        $this->getServer()->getCommandMap()->registerAll('raid', [
            new ServerCommand('server')
        ]);
    }
}