<?php
namespace Trojanbox\Mvc;

abstract class ControllerAbstract
{

    protected $view = null;

    protected $layout = null;

    public function __construct()
    {
        $this->layout = new Layout();
        $this->view = new View();
        $this->view->setLayout($this->layout);
    }

    public function loadLayoutConfig(array $config)
    {
        $this->layout->setConfig($config);
    }
    
    /**
     * 跳转到指定视图，输出最终的HTML
     */
    protected function render($address = null)
    {
    	$this->view->render($address);
    }

    /**
     * 跳转到指定页面
     *
     * @param string $url 指定的URL
     * @param number $time 等待时间
     */
    protected function redirect($url, $time = 2000)
    {
        echo '
			<script>
				setTimeout(function () {
					window.location.href="' . $url . '";
				},' . $time . ');
			</script>
		';
    }

    /**
     * 返回到指定页面
     *
     * @param number $number 后退次数
     * @param number $time 等待时间
     */
    protected function refresh($number = 1, $time = 2000)
    {
        echo '
			<script>
				setTimeout(function () {
					history.go(-' . $number . ');
				},' . $time . ');
			</script>
		';
    }
}