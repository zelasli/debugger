<?php
/**
 * Zelasli - PHP web framework
 *
 * @package Zelasli\Debugger
 * @author Rufai Limantawa <rufailimantawa@gmail.com>
 * @version 0.1.0
 */

namespace Zelasli\Debugger;

/**
 * Debugger engine class
 * 
 */
class Engine
{
    /**
     * System Debug Mode
     * 
     * @var bool
     */
    protected $mode;

    /**
     * System Environment
     * 
     * @var string
     */
    protected $environment;

    /**
     * Debug Handler
     * 
     * @var Handler
     */
    protected $handler;

    /*
     * Debugger __construct()
     * 
     * @param bool $mode
     * @param string $environment
     * 
     * @return $this
     */
    public function __construct(bool $mode = false, string $environment = 'production')
    {
        $this->mode = $mode;
        $this->environment = $environment;
    }

    /**
     * Initialize debugger
     * 
     * @return void
     */
    public function initialize(): void
    {
        if ($this->environment == 'production') {
            ini_set('display_errors', '0');

            error_reporting(
                E_ALL & 
                ~E_DEPRECATED & 
                ~E_NOTICE & 
                ~E_STRICT & 
                ~E_USER_DEPRECATED & 
                ~E_USER_NOTICE
            );
        } elseif ($this->environment == 'development') {
            ini_set(
                'display_errors',
                $this->mode ? '1' : '0' 
            );
            error_reporting(-1);
        }

        $this->handler = new Handler($this);
    }

    /**
     * Get debug mode
     * 
     * @return bool
     */
    public function getMode(): bool
    {
        return $this->mode;
    }
}
