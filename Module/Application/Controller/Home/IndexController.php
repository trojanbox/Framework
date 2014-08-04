<?php
namespace Application\Controller\Home;

use Trojanbox\Mvc\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        echo 1;
        echo 2;
        $this->display();
    }
}
