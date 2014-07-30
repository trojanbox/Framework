<?php
namespace Trojanbox\Package;

use Trojanbox\Package\PackageInterface\PackageManagerInterface;
use Trojanbox\Exception\ApplicationErrorException;

class PackageManager implements PackageManagerInterface
{

    private static $_self = null;

    private static $_autoLoad = false;

    private $_packageLists = array();

    private $_sourceLists = array();

    private $_cache = null;

    private function __construct()
    {
        
    }

    public static function getInstace()
    {
        if (self::$_self == null) {
            self::$_self = new self();
        }
        return self::$_self;
    }

    public function getLoadPackage()
    {
        return $this->_packageLists;
    }

    public function getLoadSource()
    {
        return $this->_sourceLists;
    }

    /**
     * 是否自动加载所有包信息，生产模式中请关闭该选项
     * 
     * @param bool $state            
     */
    public static function setAutoLoad($state = false)
    {
        self::$_autoLoad = $state;
    }

    /**
     * 加载所有包信息
     */
    public function loadPackage()
    {
        //if ((null === ($result = $this->_cache->load('SourceLists'))) || self::$_autoLoad == true) {
            $this->getFileInfo(WORKSPACE . 'Package' . DS);
            $result['package_lists'] = $this->_packageLists;
            $result['source_lists'] = $this->_sourceLists;
            //$this->_cache->save('SourceLists', $result);
        //}
        $this->_packageLists = $result['package_lists'];
        $this->_sourceLists = $result['source_lists'];
    }

    /**
     * 获取资源信息
     * 
     * @param unknown $key            
     * @throws ClassNotFoundException
     * @return multitype:
     */
    public function getSource($key)
    {
        $keyFix = $key . '.php';
        if (array_key_exists($keyFix, $this->_sourceLists)) {
            $this->_packageLists[$this->_sourceLists[$keyFix]]['package_name'] = $this->_sourceLists[$keyFix];
            return $this->_packageLists[$this->_sourceLists[$keyFix]];
        }
        
        return false;
    }

    /**
     * 获取目录结构信息
     * 
     * @param unknown $sourceDirectory            
     */
    private function getFileInfo($sourceDirectory)
    {
        $directoryIterator = new \DirectoryIterator($sourceDirectory);
        while ($directoryIterator->valid()) {
            if ($directoryIterator->getFilename() == '..' || $directoryIterator->getFilename() == '.') {
                $directoryIterator->next();
                continue;
            }
            switch ($directoryIterator->getType()) {
                case 'file':
                    $fileSuffix = explode('.', $directoryIterator->getBasename());
                    $fileSuffix = strtolower($fileSuffix[count($fileSuffix) - 1]);
                    if ($fileSuffix != 'phar') {
                        $directoryIterator->next();
                        continue;
                    }
                    
                    try {
                        $config = unserialize(include_once $directoryIterator->getPathname());
                        $this->_sourceLists = array_merge($this->_sourceLists, $config['class_lists']);
                        $search = array(
                            APP_PACKAGE,
                            DIRECTORY_SEPARATOR . $directoryIterator->getFilename(),
                            $directoryIterator->getFilename()
                        );
                        $config['extend_info']['verify'] = true;
                        $config['extend_info']['directory'] = str_replace($search, '', $directoryIterator->getPathname());
                        $this->_packageLists = array_merge($this->_packageLists, array(
                            $directoryIterator->getFilename() => $config['extend_info']
                        ));
                    } catch (ApplicationErrorException $e) {
                        // 容错
                    }
                    break;
                case 'dir':
                    $this->getFileInfo($directoryIterator->getRealPath());
                    break;
            }
            $directoryIterator->next();
        }
    }
}