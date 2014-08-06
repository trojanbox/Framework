<?php
namespace Test\Widget;

use Trojanbox\Mvc\WidgetAbstract;

class DefaultWidget extends WidgetAbstract 
{
    public function main()
    {
        echo 'default [';
        echo $this->ccc;
        echo ']';
        $this->render();
    }
}