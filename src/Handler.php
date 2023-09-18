<?php
/**
 * Zelasli - PHP web framework
 *
 * @package Zelasli\Debugger
 * @author Rufai Limantawa <rufailimantawa@gmail.com>
 * @version 0.1
 */

namespace Zelasli\Debugger;

use ErrorException;
use Throwable;

/**
 * Handler class for handling the exceptions and errors
 * 
 */
class Handler
{
    /**
     * Level of the nested output buffer
     * 
     * @var int
     */
    protected $ob_level;

    /**
     * Debugger engine instance
     * 
     * @var Engine
     */
    protected Engine $debugger;

    /**
     * Handler __construct()
     * 
     * @param Engine $debugger
     */
    public function __construct(Engine $debugger)
    {
        $this->ob_level = ob_get_level();
        $this->debugger = $debugger;

        set_exception_handler([$this, 'handleException']);

        set_error_handler([$this, 'handleError']);
    }

    /**
     * Custom exception handler that handles any uncaught errors and exceptions.
     * And display the errors.
     * 
     * @param Throwable $exception
     * 
     * @return void
     */
    public function handleException(Throwable $exception): void
    {
        [
            $statusCode,
            $exitCode
        ] = $this->resolveCodes($exception);

        if (PHP_SAPI != 'cli' || !defined('STDIN')) {
            header($_SERVER["SERVER_PROTOCOL"] . " {$statusCode}");
        }

        $this->render($exception, $statusCode);

        exit($exitCode);
    }
    
    /**
     * When a user trigger it with trigger_error(), error handler will catches 
     * the error. So throw the error to exceptions and let the exception 
     * handler catches it.
     * 
     * @param int $number
     * @param string $message
     * @param string $file
     * @param int $line
     * @param array $context
     * 
     * @return void
     * @throws ErrorException
     */
    public function handleError($number, $message, $file = null, $line = null, $context = null)
    {
        throw new ErrorException($message, 0, $number, $file, $line);
    }

    /**
     * 
     * @param Throwable $throwable
     * @param int $statusCode
     * 
     * @return void
     */
    protected function render(Throwable $throwable, int $statusCode): void
    {
        $data = [];

        if ($throwable instanceof RenderExceptionInterface) {
            $out = $throwable->render();
        } else {
            $data['title'] = get_class($throwable);
            $data['type'] = get_class($throwable);
            $data['code'] = $statusCode;
            $data['message'] = $throwable->getMessage() ?? "(NIL)";
            $data['file'] = $throwable->getFile();
            $data['line'] = $throwable->getLine();
            
            // Is current buffer ahead of handler's buffer? turn it off.
            if (ob_get_level() > $this->ob_level) {
                ob_end_clean();
            }

            extract($data);
            
            ob_start();
            
            if ($this->debugger->getMode()) {
                include_once 'views/error_exception.php';
            } else {
                include_once 'views/production.php';
            }
            
            $out = ob_get_contents();
            ob_end_clean();
        }

        echo $out;
    }

    /**
     * Resolve the HTTP Status code and exit code from Throwable
     * 
     * @param Throwable $throwable
     * 
     * @return array
     */
    protected function resolveCodes(Throwable $throwable): array
    {
        $code = abs($throwable->getCode());
        $exitCode = 1;

        // Is HTTP Request status code
        if (in_array($code, range(100, 599))) {
            $exitCode = ($code > 125) ? 1 : $code;
        } else {
            $code = 500;
            $exitCode = 1;
        }
        
        return [
            $code,
            $exitCode
        ];
    }
}
