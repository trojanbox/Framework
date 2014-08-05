<?php
namespace Trojanbox\Mvc;

use Trojanbox\Di\ServiceLocator;
use Trojanbox\Framework\Exception\ViewException;
use Trojanbox\Framework\FrameworkSupportAbstract;

class View extends FrameworkSupportAbstract
{

    protected $viewfile = null;

    protected $layout = null;

    public function __construct()
    {}

    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;
    }

    public function render($viewfile = null)
    {
        if ($viewfile == null) {
            $httpRequestArgs = ServiceLocator::httpRequestArgs();
            $view = APP_MODULE . $httpRequestArgs['module'] . DS . 'Template' . DS . 'View' . DS . $httpRequestArgs['directory'] . ucfirst($httpRequestArgs['controller']) . DS . $httpRequestArgs['action'] . '.html';
        } else {
            $dirconfig = self::falsePathParse($viewfile);
            $view = APP_MODULE . 'Template' . DS . 'View' . $dirconfig['alias'] . DS . 'View' . $dirconfig['directory'] . '.html';
        }
        
        if (! is_file($view)) {
            throw new ViewException('Not found view file: ' . $viewfile);
        }
        
        $this->viewfile = $view;
        ob_start();
        require $view;
        $content = ob_get_clean();
        $this->layout->setViewContent($content);
        $this->layout->render();
    }

    /**
     * 渲染 Widget
     *
     * @param WidgetAbstract $widget            
     */
    public function renderWidget(WidgetAbstract $widget)
    {}
}