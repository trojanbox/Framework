<?php
namespace Trojanbox\Exception;

include_once 'DefaultException.php';

class ErrorExceptionHandle
{

    /**
     * 设置错误处理器用于将错误转换成异常
     * 
     * @throws ApplicationErrorException
     */
    public static function setErrorHandle()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline)
        {
            if (error_reporting() == 0)
                return;
            throw new ApplicationErrorException($errstr, $errno, $errno, $errfile, $errline);
        }, E_ALL);
    }

    /**
     * 捕捉致命错误
     * 
     * @return void string
     */
    public static function setFatalErrorHandle()
    {
        register_shutdown_function(function ()
        {
            $errorInfo = error_get_last();
            if (empty($errorInfo))
                return;
            $basicTemplate = function ($title, $message, $file, $line)
            {
                return '<div style="background: #5C5C5C; padding: 5px 8px; color: #fff; font-size: 12px; margin: 2px 0px;"><b>' . $title . ':</b> ' . $message . '<br /><b>ERROR FILE:</b> ' . $file . ' (' . $line . ')</div>';
            };
            ob_end_clean();
            echo $basicTemplate('FATEL ERROR', $errorInfo['message'], $errorInfo['file'], $errorInfo['line']);
        });
    }

    /**
     * 设置异常处理器用于捕捉未捕捉的异常 产生一个致命异常错误信息
     */
    public static function setExceptionHandle()
    {
        set_exception_handler(function ($exception)
        {
            
            $errorCodeString = '';
            switch ($exception->getCode()) {
                case E_ALL:
                    $errorCodeString = 'ERROR';
                    break;
                case E_COMPILE_ERROR:
                    $errorCodeString = 'COMPILE ERROR';
                    break;
                case E_COMPILE_WARNING:
                    $errorCodeString = 'COMPILE WARNING ERROR';
                    break;
                case E_CORE_ERROR:
                    $errorCodeString = 'CORE ERROR';
                    break;
                case E_DEPRECATED:
                    $errorCodeString = 'DEPRECATED ERROR';
                    break;
                case E_ERROR:
                    $errorCodeString = 'ERROR';
                    break;
                case E_NOTICE:
                    $errorCodeString = 'NOTICE ERROR';
                    break;
                case E_PARSE:
                    $errorCodeString = 'PARSE ERROR';
                    break;
                case E_RECOVERABLE_ERROR:
                    $errorCodeString = 'RECOVERABLE ERROR';
                    break;
                case E_STRICT:
                    $errorCodeString = 'STRICT ERROR';
                    break;
                case E_USER_DEPRECATED:
                    $errorCodeString = 'USER_DEPRECATED ERROR';
                    break;
                case E_USER_ERROR:
                    $errorCodeString = 'USER ERROR';
                    break;
                case E_USER_NOTICE:
                    $errorCodeString = 'USER NOTICE ERROR';
                    break;
                case E_USER_WARNING:
                    $errorCodeString = 'USER WARNING ERROR';
                    break;
                case E_WARNING:
                    $errorCodeString = 'WARNING ERROR';
                    break;
                default:
                    $errorCodeString = 'EXCEPTION ERROR';
                    break;
            }
            
            $errorInfomation = '<html><body><p style=" font-size: 22px; font-weight: bolder;">Uncaught Exception Message: ' . $exception->getMessage();
            $errorInfomation .= '<br /><font style="font-size: 18px;">>> Exception Class: ' . get_class($exception) . '</font>';
            $errorInfomation .= '<br /><font style="font-size: 18px;">>> Exception Code: ' . $errorCodeString . '</font>';
            $errorInfomation .= '<br /><font style="font-size: 18px;">>> ' . $exception->getFile() . ' [' . $exception->getLine() . ']' . '</font></p>';
            foreach ($exception->getTrace() as $key => $value) {
                $errorInfomation .= '<p><font style="font-weight: bolder;">>> ' . $key . '</font> ';
                $errorInfomation .= empty($value['class']) ? null : $value['class'];
                $errorInfomation .= empty($value['type']) ? null : $value['type'];
                $errorInfomation .= empty($value['function']) ? null : $value['function'];
                
                $errorInfomation .= '(' . ')';
                $errorInfomation .= '<br />&nbsp;&nbsp;&nbsp;';
                $errorInfomation .= empty($value['file']) ? 'No Found directory' : $value['file'];
                $line = empty($value['line']) ? '?' : $value['line'];
                $errorInfomation .= ' [' . $line . '] ' . '</p>';
            }
            $errorInfomation .= '</body></html>';
            echo $errorInfomation;
        });
    }
}