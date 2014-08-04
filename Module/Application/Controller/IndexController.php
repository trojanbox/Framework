<?php
namespace Application\Controller;

use Trojanbox\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
	{
	    $this->view->omyge = 'dd';
	    $this->render();       // 加载块
        $this->display();      // 渲染页面
	}
}
