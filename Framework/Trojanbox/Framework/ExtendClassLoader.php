<?php
namespace Trojanbox\Framework;

use Trojanbox\File\Exception\DirectoryNotFoundException;

/**
 * 加载扩展类
 * 
 * @author Administrator
 *        
 */
class ExtendClassLoader
{

    private static $_self;

    private static $_directory;

    private function __construct()
    {}

    /**
     * 设置扩展类目录
     * 
     * @param unknown $dir            
     * @throws DirectoryNotFoundException
     */
    public static function setExtendDir($dir)
    {
        if (! is_dir($dir)) {
            throw new DirectoryNotFoundException("目录不存在！");
        }
        self::$_directory = $dir;
    }

    /**
     * 加载扩展类
     * 
     * @param unknown $fileName            
     */
    public static function loadExtendClass($fileName)
    {
        include_once self::$_directory . $fileName;
    }
}