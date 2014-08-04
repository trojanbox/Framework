<?php
namespace Trojanbox\Mvc;

use Trojanbox\Framework\Exception\ViewException;
use Trojanbox\Di\ServiceLocator;

class View
{
    protected $viewfile = null;

    public function __construct($viewfile)
    {
        $httpRequestArgs = ServiceLocator::httpRequestArgs();
        $view = $httpRequestArgs['directory'] . ucfirst($httpRequestArgs['controller']) . DS . $httpRequestArgs['action'] . '.html';
        $viewDirectory = APP_APPLICATION_VIEW . $view;
        
        if (! is_file($viewfile)) {
            throw new ViewException('Not found view file: ' . $viewfile);
        }
        
        $this->viewfile = $viewfile;
    }

    public function display()
    {
        include $this->viewfile;
    }
}