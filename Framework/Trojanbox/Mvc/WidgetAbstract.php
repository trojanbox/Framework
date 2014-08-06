<?php
namespace Trojanbox\Mvc;

use Trojanbox\Framework\FrameworkSupportAbstract;
use Trojanbox\Framework\Exception\ViewException;

abstract class WidgetAbstract extends FrameworkSupportAbstract
{

    protected $data = array();

    protected $includeFile = null;
    
    final public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    final public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

    /**
     * 定义微件的主体内容<br />
     * 通过 $this->xx 直接调用传进来的参数，如果参数不存在则返回空。
     */
    abstract public function main();

    /**
     * 渲染模板
     * 
     * @param string $widgetName
     */
    final public function render($widgetName = null)
    {
        $reflection = new \ReflectionClass($this);
        if (null === $widgetName) {
            $namespace = str_replace(array(
                '\\Widget',
                '\\'
            ), array(
                DS . 'Template' . DS . 'Widget',
                DS
            ), $reflection->getNamespaceName());
            $includeFile = APP_MODULE . $namespace . DS . $reflection->getShortName() . '.html';
        } else {
            $dirconfig = self::falsePathParse($widgetName);
            $includeFile = APP_MODULE . $dirconfig['alias'] . DS . 'Template' . DS . 'Widget' . DS . $dirconfig['directory'] . '.html';
        }
        $this->includeFile = $includeFile;
    }
    
    /**
     * 执行
     * 
     * @throws ViewException
     */
    final public function display()
    {
        if (!is_file($this->includeFile)) {
            $reflection = new \ReflectionClass($this);
            throw new ViewException('Widget ' . $reflection->getName() . ' uninitialized.', E_WARNING);
        }
    	require $this->includeFile;
    }
}