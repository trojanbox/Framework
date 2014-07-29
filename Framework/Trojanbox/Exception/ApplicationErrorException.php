<?php
namespace Trojanbox\Exception;

/**
 * 应用程序错误处理
 *
 * @author Administrator
 *        
 */
class ApplicationErrorException extends \ErrorException
{

    public function __toString()
    {
        $basicTemplate = function ($title, $message, $file, $line)
        {
            return '<div style="background: #FF5858; padding: 5px 8px; color: #fff; font-size: 12px; margin: 2px 0px;"><b>' . $title . ':</b> ' . $message . '<br /><b>ERROR FILE:</b> ' . $file . ' (' . $line . ')</div>';
        };
        
        switch ($this->code) {
            case E_WARNING:
                $errorInfomation = $basicTemplate('WARNING ERROR', $this->message, $this->file, $this->line);
                break;
            case E_STRICT:
                $errorInfomation = $basicTemplate('STRICT ERROR', $this->message, $this->file, $this->line);
                break;
            case E_NOTICE:
                $errorInfomation = $basicTemplate('NOTICE ERROR', $this->message, $this->file, $this->line);
                break;
            case E_USER_DEPRECATED:
                $errorInfomation = $basicTemplate('USER DEPRECATED ERROR', $this->message, $this->file, $this->line);
                break;
            case E_USER_ERROR:
                $errorInfomation = $basicTemplate('USER ERROR ERROR', $this->message, $this->file, $this->line);
                break;
            case E_USER_NOTICE:
                $errorInfomation = $basicTemplate('USER NOTICE ERROR', $this->message, $this->file, $this->line);
                break;
            case E_USER_WARNING:
                $errorInfomation = $basicTemplate('USER WARNING ERROR', $this->message, $this->file, $this->line);
                break;
            default:
                $errorInfomation = '<html><body><p style="font-family: \'consolas\'; font-size: 22px; font-weight: bolder;">Error Message: ' . $this->message;
                $errorInfomation .= '<br /><font style="font-size: 18px;">>> Error Code ' . $this->code . '</font>';
                $errorInfomation .= '<br /><font style="font-size: 18px;">>> ' . $this->file . ' [' . $this->line . ']' . '</font></p>';
                
                foreach ($this->getTrace() as $key => $value) {
                    $errorInfomation .= '<p style="font-family: \'consolas\'"><font style="font-weight: bolder;">## ' . $key . '</font> ';
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
                break;
        }
        
        return $errorInfomation;
    }
}