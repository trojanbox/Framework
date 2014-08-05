<?php
namespace Trojanbox\Mvc;

use Trojanbox\Framework\Exception\ViewException;
use Trojanbox\Framework\FrameworkSupportAbstract;

class Layout extends FrameworkSupportAbstract
{

    protected $widgetLists = array();

    protected $config = array();

    protected $viewcontent = null;
    
    public function __construct()
    {}

    /**
     * 设置配置文件
     *
     * @param array $config            
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * 渲染布局文件
     */
    final public function render()
    {
        if (isset($this->config['layout_switch']) && $this->config['layout_switch'] === true) {
        	$this->import($this->config['main']);
        }
    }
    
    /**
     * 设置视图内容
     * 
     * @param string $content
     */
    public function setViewContent($content)
    {
        $this->viewcontent = $content;
    }
    
    /**
     * 取得视图内容
     * 
     */
    public function getViewContent()
    {
    	if (array_key_exists('viewcontent', get_object_vars($this))) {
    	    echo $this->viewcontent;
    	    return;
    	}
    	throw new ViewException('Ignoring Figure Output');
    }
    
    /**
     * 导入布局文件
     *
     * @param string $string            
     */
    public function import($string)
    {
        $dirconfig = self::falsePathParse($string);
        $layoutfile = APP_MODULE . $dirconfig['alias'] . DS . 'Template' . DS . 'Layout' . DS . $dirconfig['directory'] . '.html';
        if (! is_file($layoutfile)) {
            throw new ViewException('Not found layout page ' . $dirconfig['directory'] . '.');
        }
        require $layoutfile;
    }
    
    public function __set($key, WidgetAbstract $value)
    {
        $this->widgetLists[$key] = $value;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->widgetLists)) {
            return $this->widgetLists[$key]->render();
        }
        throw new ViewException('Not found widget ' . $key . '.', E_ERROR);
    }
}