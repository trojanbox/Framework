<?php
namespace Application\Controller\Home;

use Trojanbox\Framework\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        echo 1;
        
        $this->display();
    }
}