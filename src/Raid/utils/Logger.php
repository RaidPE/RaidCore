<?php

/*
 * Original code from PocketMine-MP
 *
*/

namespace Raid\utils;

use LogLevel;
use pocketmine\Server;

class Logger implements \AttachableLogger{

    private $prefix;

    /** @var \LoggerAttachment[] */
    private $attachments = [];

    public function addAttachment(\LoggerAttachment $attachment){
        $this->attachments[spl_object_hash($attachment)] = $attachment;
    }

    public function removeAttachment(\LoggerAttachment $attachment){
        unset($this->attachments[spl_object_hash($attachment)]);
    }

    public function removeAttachments(){
        $this->attachments = [];
    }

    public function getAttachments(){
        return $this->attachments;
    }

    public function __construct(string $prefix){
        $this->prefix = $prefix . ' >> ';
    }

    public function emergency($message){
        $this->log(LogLevel::EMERGENCY, $message);
    }

    public function alert($message){
        $this->log(LogLevel::ALERT, $message);
    }

    public function critical($message){
        $this->log(LogLevel::CRITICAL, $message);
    }

    public function error($message){
        $this->log(LogLevel::ERROR, $message);
    }

    public function warning($message){
        $this->log(LogLevel::WARNING, $message);
    }

    public function notice($message){
        $this->log(LogLevel::NOTICE, $message);
    }

    public function info($message){
        $this->log(LogLevel::INFO, $message);
    }

    public function debug($message){
        $this->log(LogLevel::DEBUG, $message);
    }

    public function logException(\Throwable $e, $trace = null){
        Server::getInstance()->getLogger()->logException($e, $trace);
    }

    public function log($level, $message){
        Server::getInstance()->getLogger()->log($level, $this->prefix . $message);
        foreach($this->attachments as $attachment){
            $attachment->log($level, $message);
        }
    }
}
