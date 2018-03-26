<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 錯誤處理
 * @package Helpers
 */
class ErrorStack
{
    protected static $errors = [];

    /**
     * 丟入錯誤訊息
     * @param  string   $msg     錯誤訊息
     * @param  string   $code    錯誤代碼
     * @return string  錯誤訊息
     */
    public static function push($msg, $code = null)
    {
        if ($code) {
            self::$errors[] = ['msg'  => $msg, 'code' => $code];
        } else {
            self::$errors[] = $msg;            
        }
    }

    /**
     * 取得錯誤訊息
     * @return mixed 錯誤訊息
     */
    public static function pop()
    {

        return array_pop(self::$errors);
    }

    /**
     * 取得所有錯誤
     * @return array 所有錯誤
     */
    public static function getAll()
    {
        return array_reverse(self::$errors);
    }
}