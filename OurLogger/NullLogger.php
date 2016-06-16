<?php
/**
 * Created by PhpStorm.
 * User: pirate
 * Date: 14.06.16
 * Time: 22:37
 */

namespace OurLogger;

use Psr\Log\AbstractLogger;

class NullLogger extends AbstractLogger
{
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
        // noop
    }

}