<?php
namespace Trojanbox\Framework;

abstract class FrameworkSupportAbstract
{

    /**
     * 伪路径解析
     * 
     * @param string $string
     * @return array
     */
    public static function falsePathParse($string)
    {
        $dirArray = explode('.', $string);
        $result['alias'] = $dirArray[0];
        unset($dirArray[0]);
        $result['directory'] = implode(DS, $dirArray);
        return $result;
    }
}