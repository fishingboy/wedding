<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 種子的父類別
 */
abstract class Seeder_base
{
    protected $CI;

    /**
     * 執行順序 (大的排前面)
     * @var integer
     */
    public $priority = 0;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    abstract public function run();
}