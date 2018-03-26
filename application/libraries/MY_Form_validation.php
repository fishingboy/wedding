<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 擴充 CI_Form_validation
 */
class MY_Form_validation extends CI_Form_validation
{
    /**
     * 白名單驗證
     * @param  string $str        欄位值
     * @param  string $white_list 白名單(/隔開)
     * @return boolean
     */
    public function white_list($str, $white_list)
    {
        if ( ! $white_list) {
            return false;
        }

        $list = explode('/', $white_list);
        return in_array($str, $list);
    }

    /**
     * 驗證字的寬度(英文 1 中文 2)
     * @param  string $str 欄位值
     * @param $max_width
     * @return boolean
     */
    public function max_width($str, $max_width)
    {
        if ( ! $max_width) {
            return false;
        }

        $width = mb_strwidth($str, "UTF-8");

        return $width <= $max_width;
    }

    /**
     * 驗證字的寬度(英文 1 中文 2)
     * @param  string $str 欄位值
     * @param $min_width
     * @return boolean
     */
    public function min_width($str, $min_width)
    {
        if ( ! $min_width) {
            return false;
        }

        $width = mb_strwidth($str, "UTF-8");

        return $width >= $min_width;
    }
}
