<?php

namespace Raid;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    public function onLoad()
    {
        new Core($this);
    }
}