<?php
namespace Test\Controller;

class IndexController extends ConfigController
{

    public function __construct()
    {
    	parent::__construct();
    }
    
    public function indexAction()
    {
    	$this->render();
    }
}