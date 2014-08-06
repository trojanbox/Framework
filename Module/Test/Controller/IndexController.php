<?php
namespace Test\Controller;

use Test\Widget\DefaultWidget;
class IndexController extends ConfigController
{

    public function __construct()
    {
    	parent::__construct();
    }
    
    public function indexAction()
    {
        $this->view->aaa = 'aaa';
        $this->widget->default = new DefaultWidget(array('ccc' => 'default'));
    	$this->render();
    }
}