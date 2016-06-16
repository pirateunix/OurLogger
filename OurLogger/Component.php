<?php
/**
 * Created by PhpStorm.
 * User: pirate
 * Date: 12.06.16
 * Time: 23:33
 */

namespace OurLogger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Component extends AbstractLogger
{
    private $loggers;

    /**
     * Added object in array
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return null
     */
    public function addLogger(LoggerInterface $logger)
    {
        $this->loggers[] = $logger;

    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return null
     */
    public function log($level, $message, array $context = array())
    {

        $msg = date('Y-m-d H:i:s') . ' ' . strtoupper($level) . 'LVL ' . $message . "\n";

        foreach ($this->loggers as $logger) {
            $logger->log($level, $msg);
        }


    }
}