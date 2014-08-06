<?php
namespace Trojanbox\Framework;

class Tools
{

    /**
     * 清理数组并重组数组（下标为数字是有效）
     *
     * @param $array 数组            
     */
    public static function clearArray($array = null)
    {
        if (empty($array))
            throw new \Exception('这不是一个参数');
        $result = array();
        foreach ($array as $value) {
            if (is_null($value) || $value == '')
                continue;
            $result[] = $value;
        }
        return $result;
    }

    /**
     * 获得浏览器版本信息
     */
    static public function getBrowserVersion()
    {
        $Agent = $_SERVER['HTTP_USER_AGENT'];
        $browseragent = ""; // 浏览器
        $browserversion = ""; // 浏览器的版本
        if (preg_match('/MSIE ([0-9].[0-9]{1,2})/i', $Agent, $version)) {
            $browserversion = $version[1];
            $browseragent = "Internet Explorer";
        } elseif (preg_match('/rv:([0-9]{1,2}.[0-9]+)/i', $Agent, $version)) {
            $browserversion = $version[1];
            $browseragent = "Internet Explorer";
        } elseif (preg_match('/Opera\/([0-9]{1,2}.[0-9]{1,2})/i', $Agent, $version)) {
            $browserversion = $version[1];
            $browseragent = "Opera";
        } elseif (preg_match('/Firefox\/([0-9.]{1,5})/i', $Agent, $version)) {
            $browserversion = $version[1];
            $browseragent = "Firefox";
        } elseif (preg_match('/Chrome\/([0-9.]{1,3})/i', $Agent, $version)) {
            $browserversion = $version[1];
            $browseragent = "Chrome";
        } elseif (preg_match('/Safari\/([0-9.]{1,3})/i', $Agent, $version)) {
            $browseragent = "Safari";
            $browserversion = "";
        } else {
            $browserversion = "";
            $browseragent = "Unknown";
        }
        return $browseragent . " " . $browserversion;
        exit();
    }
}