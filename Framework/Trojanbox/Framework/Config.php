<?php
namespace Trojanbox\Framework;

use Trojanbox\Framework\Exception\ConfigException;

class Config extends FrameworkSupportAbstract
{

    protected static $mapping = array();

    /**
     * 加载配置文件
     *
     * @param string $string            
     * @return multitype:
     */
    public static function loader($directory, $key = null)
    {
        
        $directoryConfig = self::falsePathParse($directory);    
        
        if (! empty(self::$mapping[$directory])) {
            if (! is_null($key) && array_key_exists($key, self::$mapping[$directory])) {
                return self::$mapping[$directory][$key];
            } else {
                throw new ConfigException('Undefined key ' . $key);
            }
            return self::$mapping[$directory];
        }
        
        if ($directoryConfig['alias'] == 'System') {
            $include = WORKSPACE . 'System' . DS . 'Config' . DS . $directoryConfig['directory'] . '.php';
        } else {
            $include = APP_MODULE . $directoryConfig['alias'] . DS . 'Config' . DS . $directoryConfig['directory'] . '.php';
        }
        
        if (! is_file($include)) {
            throw new ConfigException('Not found config file :' . $directoryConfig['directory'], E_WARNING);
        }
        
        self::$mapping[$directory] = include $include;
        
        if (! is_null($key) && array_key_exists($key, self::$mapping[$directory])) {
            return self::$mapping[$directory][$key];
        }
        return self::$mapping[$directory];
    }
}