<?php

namespace Raid;

use pocketmine\Server;
use Raid\command\ServerCommand;
use Raid\utils\Logger;

class Core
{
    /** @var Core */
    private static $instance = null;

    /** @var Server */
    private $server;

    /** @var Logger */
    private $logger;

    public function __construct(Server $server)
    {
        self::$instance = $this;
        $this->server = $server;
        $this->logger = new Logger('Core');
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function getServerName()
    {
        return $this->server->getProperty('server-name', 'raidpe.com');
    }

    public function registerCoreCommands()
    {
        $this->server->getCommandMap()->registerAll('raid', [
            new ServerCommand('server')
        ]);
    }
}