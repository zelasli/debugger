<?php
/**
 * Zelasli - PHP web framework
 *
 * @package Zelasli
 * @author Rufai Limantawa
 * @package Zelasli\Debugger
 */

namespace Zelasli\Debugger;

class Engine
{
    /**
     * Debug mode
     * 
     * @var bool
     */
    protected $mode;

    public function __construct(bool $mode = false) {
        $this->mode = $mode;
    }

    /**
     * Initialize debugger
     * 
     * @return void
     */
    public function initialize()
    {
        error_reporting(-1);
    }
}
