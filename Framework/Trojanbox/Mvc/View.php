<?php
namespace Trojanbox\Mvc;

use Trojanbox\Di\ServiceLocator;
use Trojanbox\Framework\Exception\ViewException;
use Trojanbox\Framework\FrameworkSupportAbstract;

class View extends FrameworkSupportAbstract
{

    protected $viewfile = null;

    protected $layout = null;

    protected $widget = null;
    
    public function __construct()
    {}

    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;
    }

    public function setWidget(WidgetManager $widget)
    {
    	$this->widget = $widget;
    }
    
    /**
     * 渲染
     * @param string $viewfile
     * @throws ViewException
     */
    public function render($viewfile = null)
    {
        if ($viewfile == null) {
            $httpRequestArgs = ServiceLocator::httpRequestArgs();
            $view = APP_MODULE . $httpRequestArgs['module'] . DS . 'Template' . DS . 'View' . DS . $httpRequestArgs['directory'] . ucfirst($httpRequestArgs['controller']) . DS . $httpRequestArgs['action'] . '.html';
        } else {
            $dirconfig = self::falsePathParse($viewfile);
            $view = APP_MODULE . $dirconfig['alias'] . DS . 'Template' . DS . 'View' . DS . $dirconfig['directory'] . '.html';
        }
        
        if (! is_file($view)) {
            throw new ViewException('Not found view file: ' . $viewfile);
        }
        
        $this->viewfile = $view;
        
        // 程序片渲染
        ob_start();
        require $view;
        $content = ob_get_contents();
        ob_end_clean();
        $this->layout->setViewContent($content);
        
        // 整体渲染
        ob_start();
        $this->layout->render();
        $renderhtml = ob_get_contents();
        ob_end_clean();
        echo $renderhtml;
    }
}