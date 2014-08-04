<?php
namespace Trojanbox\Framework;

class Route
{

    private static $only = null;

    private $url = null;

    private $config = null;

    private $state = false;

    private $MUrl = null;

    private function __construct()
    {}

    /**
     * 创建唯一路由示例 - 开启路由后所有的URL将被重写
     * 
     * @param string $array
     *            路由配置
     * @return \Trojanbox\Route\Loader
     */
    public static function getInstance($array = null)
    {
        if (! is_object(self::$only)) {
            self::$only = new self();
            if (! empty($array))
                self::$only->setConfig($array);
        }
        return self::$only;
    }

    /**
     * 导入配置
     * 
     * @param unknown $config            
     * @return \Trojanbox\Route\Loader
     */
    public function setConfig($config)
    {
        $this->config = $config;
        $this->state = true;
        return $this;
    }

    /**
     * 获得路由状态
     * 
     * @return boolean
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * 设置URL
     * 
     * @param string $url            
     * @throws \Trojanbox\Exception
     * @return \Trojanbox\Route\Loader
     */
    public function setUrl($url = null)
    {
        if (empty($url))
            throw new \Exception('这不是一个URL');
        $this->url = $url;
        $this->_execRoute();
        return $this;
    }

    /**
     * 传出URL
     * 
     * @throws \Trojanbox\Exception
     */
    public function getUrl()
    {
        if (empty($this->url))
            throw new \Exception('请执行' . __CLASS__ . '::setUrl()进行赋值操作！');
        return $this->MUrl;
    }

    final protected function _execRoute()
    {
        $url = array();
        $urlTrue = null;
        
        foreach ($this->config as $key => $value)
            if (preg_match($key, $this->url, $returnUrlParams)) {
                preg_match_all('/\$(\d+)/', $value, $trueParams);
                foreach ($trueParams[1] as $key2 => $value2)
                    $url[] = $returnUrlParams[$value2];
                $urlTrue = str_replace($trueParams[0], $url, $value);
                $this->MUrl = $urlTrue;
                break;
            } else {
                $this->MUrl = $this->url;
            }
        return $this;
    }
}
