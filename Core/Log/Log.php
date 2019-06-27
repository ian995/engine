<?php
/**
 * Log facade
 * @author edgebal
 */

namespace Minds\Core\Log;

use Minds\Core\Config;
use Minds\Core\Di\Di;
use Throwable;

class Log
{
    /** @var Config */
    protected $config;

    /** @var LoggerContext[] */
    protected $contexts = [];

    /** @var Log */
    protected static $instance;

    /**
     * Logger constructor.
     * @param Config $config
     */
    public function __construct(
        $config = null
    )
    {
        $this->config = $config ?: Di::_()->get('Config');
    }

    /**
     * @param $context
     * @return LoggerContext
     */
    public function get($context)
    {
        if (!isset($this->contexts[$context])) {
            $this->contexts[$context] = (new LoggerContext())
                ->setContext($context);
        }

        return $this->contexts[$context];
    }

    /**
     * @param string $namespace
     * @return string
     */
    public static function buildContext($namespace = '')
    {
        $tokens = str_ireplace(['\\Minds\\Core', '\\Minds', '\\'], ' ', '\\' . $namespace);
        return str_replace(' ', '', ucwords(trim($tokens)));
    }

    /**
     * @return Log
     */
    public static function _()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param string|Throwable $message
     * @param string $context
     * @param array $payload
     * @return bool
     */
    public static function emergency($message, $context = 'Default', array $payload = [])
    {
        return static::_()->get(static::buildContext($context))->emergency($message, $payload);
    }

    /**
     * @param string|Throwable $message
     * @param string $context
     * @param array $payload
     * @return bool
     */
    public static function alert($message, $context = 'Default', array $payload = [])
    {
        return static::_()->get(static::buildContext($context))->alert($message, $payload);
    }

    /**
     * @param string|Throwable $message
     * @param string $context
     * @param array $payload
     * @return bool
     */
    public static function critical($message, $context = 'Default', array $payload = [])
    {
        return static::_()->get(static::buildContext($context))->critical($message, $payload);
    }

    /**
     * @param string|Throwable $message
     * @param string $context
     * @param array $payload
     * @return bool
     */
    public static function error($message, $context = 'Default', array $payload = [])
    {
        return static::_()->get(static::buildContext($context))->error($message, $payload);
    }

    /**
     * @param string|Throwable $message
     * @param string $context
     * @param array $payload
     * @return bool
     */
    public static function warning($message, $context = 'Default', array $payload = [])
    {
        return static::_()->get(static::buildContext($context))->warning($message, $payload);
    }

    /**
     * @param string|Throwable $message
     * @param string $context
     * @param array $payload
     * @return bool
     */
    public static function notice($message, $context = 'Default', array $payload = [])
    {
        return static::_()->get(static::buildContext($context))->notice($message, $payload);
    }

    /**
     * @param string|Throwable $message
     * @param string $context
     * @param array $payload
     * @return bool
     */
    public static function info($message, $context = 'Default', array $payload = [])
    {
        return static::_()->get(static::buildContext($context))->info($message, $payload);
    }

    /**
     * @param string|Throwable $message
     * @param string $context
     * @param array $payload
     * @return bool
     */
    public static function debug($message, $context = 'Default', array $payload = [])
    {
        return static::_()->get(static::buildContext($context))->debug($message, $payload);
    }
}