<?php
namespace Test\Controller;

use Trojanbox\Mvc\ControllerAbstract;
use Trojanbox\Framework\Config;
use Test\Widget\DefaultWidget;

class ConfigController extends ControllerAbstract
{

    public function __construct()
    {
        parent::__construct();
        $this->layout->test = new DefaultWidget();
        $layoutConfig = Config::loader('Test.Default.Layout'); // 载入默认视图配置
        $this->loadLayoutConfig($layoutConfig);
    }
}