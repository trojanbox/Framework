<?php
namespace Trojanbox\Mvc;

use Trojanbox\Framework\Exception\ViewException;

class WidgetManager
{
    
    protected $widgetLists = array();
    
    public function __construct()
    {
    }
    
    public function __set($key, WidgetAbstract $value)
    {
        $this->widgetLists[$key] = $value;
    }
    
    public function __get($key)
    {
        if (array_key_exists($key, $this->widgetLists)) {
            $this->widgetLists[$key]->main();
            return $this->widgetLists[$key]->display();
        }
        throw new ViewException('Not found widget ' . $key . '.', E_ERROR);
    }
}