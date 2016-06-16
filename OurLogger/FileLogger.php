<?php
/**
 * Created by PhpStorm.
 * User: pirate
 * Date: 13.06.16
 * Time: 8:02
 */

namespace OurLogger;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;


class FileLogger extends AbstractLogger
{
    /**
     * @var string $filename
     */
    private $filename;
    /**
     * @var array $levels
     */
    private $levels;
    /**
     * @var array $acceptedLevels
     */
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
        $this->filename = $params['filename'];

        if (!empty($params['levels'])) {
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
        /**
         * Согласно описанию Psr3 InvalidArgumentException возникает, когда передается LogLevel,
         * который неподдерживается данной реализацией. В таком случае необходимость в свойстве $this->levels отпадает,
         * и в коснтрукторе можно переисывать $this->acceptedLevels.
         * Но в таком случае заданный файл index.php будет вызывать данное исключение всегда.
         * Поэтому было принято решение вызывать исключение, когда LogLevel не соответствует перечисленным в Psr3.
         *
         */
        if (!in_array($level, $this->acceptedLevels)) {
            throw new InvalidArgumentException('Incorrect log level');
        }
        if (in_array($level, $this->levels)) {
            file_put_contents($this->filename, (string)$message, FILE_APPEND);
        }

    }

}