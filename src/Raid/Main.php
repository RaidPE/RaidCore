<?php

namespace Raid;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    /** @var Core */
    private $core = null;

    public function onLoad()
    {
        $this->core = new Core($this);
        $this->core->registerCoreCommands();
    }
}