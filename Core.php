<?php

namespace Raid;

use pocketmine\Server;
use Raid\command\ServerCommand;
use Raid\command\VersionCommand;
use Raid\lang\Language;
use Raid\utils\Logger;
use Raid\utils\MySQL;

class Core
{
    /** @var Core */
    private static $instance = null;

    /** @var Server */
    private $server;

    /** @var Logger */
    private $logger;

    /** @var Main */
    private $plugin;

    /** @var Language */
    private $lang;

    /** @var MySQL */
    private $database;

    public function __construct(Main $plugin)
    {
        self::$instance = $this;
        $this->plugin = $plugin;
        $this->server = $plugin->getServer();
        $this->logger = new Logger('Core');
        $this->lang = new Language(__DIR__ . '/lang/locale/');

        $this->registerCoreCommands();
    }

    public static function getInstance() : Core
    {
        return self::$instance;
    }

    public function getServerName() : string
    {
        return $this->server->getProperty('server-name', 'raidpe.com');
    }

    public function getCoreVersion() : string
    {
        return $this->plugin->getDescription()->getVersion();
    }

    public function registerCoreCommands()
    {
        foreach(['version'] as $command)
            $this->server->getCommandMap()->unregister($this->server->getCommandMap()->getCommand($command));

        $this->server->getCommandMap()->registerAll('raid', [
            new ServerCommand('server'),
            new VersionCommand('version')
        ]);
    }

    public function getLogger() : Logger
    {
        return $this->logger;
    }

    public function getLanguage() : Language
    {
        return $this->lang;
    }

    public function initDatabase()
    {
        $this->database = new MySQL($this->plugin);
    }

    public function getDatabase()
    {
        return $this->database;
    }
}