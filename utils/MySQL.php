<?php

namespace Raid\utils;

use libasynql\ClearMysqlTask;
use libasynql\DirectQueryMysqlTask;
use libasynql\MysqlCredentials;
use libasynql\PingMysqlTask;
use libasynql\QueryMysqlTask;
use libasynql\result\MysqlResult;
use pocketmine\plugin\Plugin;

class MySQL
{
    /** @var Plugin */
    private $plugin;

    /** @var MysqlCredentials */
    private $credentials;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
        PingMysqlTask::init($plugin, $this->credentials = new MysqlCredentials(
            $plugin->getServer()->getConfigString('database-host', '127.0.0.1'),
            $plugin->getServer()->getConfigString('database-username', 'root'),
            $plugin->getServer()->getConfigString('database-password', ''),
            $plugin->getServer()->getConfigString('database-name', 'raid'),
            $plugin->getServer()->getConfigInt('database-port', 3306)
        ));
        // Testing
        $this->query('SELECT 1;');
    }

    public function closeAll()
    {
        ClearMysqlTask::closeAll($this->plugin, $this->credentials);
    }

    public function getCredentials() : MysqlCredentials
    {
        return $this->credentials;
    }

    public function asyncQuery(string $query, array $args = [], callable $callback = null)
    {
        $this->plugin->getServer()->getScheduler()->scheduleAsyncTask(new DirectQueryMysqlTask($this->credentials, $query, $args, $callback));
    }

    public function query(string $query, array $args = []) : MysqlResult
    {
        return (new TempQueryTask($this->credentials, $query, $args))->query();
    }
}

class TempQueryTask extends QueryMysqlTask
{
    private $query;

    private $args;

    protected function execute(){}

    public function __construct(MysqlCredentials $credentials, string $query, array $args = [])
    {
        parent::__construct($credentials);
        $this->query = $query;
        $this->args = serialize($args);

    }

    public function query() : MysqlResult
    {
        $args = unserialize($this->args);
        return MysqlResult::executeQuery($this->getMysqli(), $this->query, $args);
    }
}