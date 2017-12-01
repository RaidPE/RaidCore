<?php

namespace Raid;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onLoad()
    {
        new Core($this);
    }

    public function onEnable()
    {
        Core::getInstance()->initDatabase();
    }

    public function onDisable()
    {
        if(Core::getInstance()->getDatabase() !== null)
            Core::getInstance()->getDatabase()->closeAll();
    }
}