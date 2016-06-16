<?php
/**
 * Created by PhpStorm.
 * User: pirate
 * Date: 14.06.16
 * Time: 21:14
 */

namespace OurLogger;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;


class SyslogLogger extends AbstractLogger
{

    private $levels;
    private $acceptedLevels = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::DEBUG
    ];

    /**
     *
     * @param array $params
     *
     */
    public function __construct(array $params = array())
    {
        if (array_key_exists('levels', $params)) {

            $levels = array_intersect($params['levels'], $this->acceptedLevels);

            $this->levels = $levels;

        } else {
            $this->levels = $this->acceptedLevels;
        }

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
        if (!in_array($level, $this->acceptedLevels)) {
            throw new InvalidArgumentException('Incorrect log level');
        }
        if (in_array($level, $this->levels)) {
            syslog($level, (string)$message);
        }
    }

}