<?php

/**
 * Created by PhpStorm.
 * User: ZUVIO
 * Date: 2016/11/8
 * Time: 下午 02:08
 */
class MY_Loader extends CI_Loader
{
    /**
     * MY_Loader constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function initialize()
    {
        $this->_ci_classes = array();
        $this->_ci_loaded_files = array();
        $this->_ci_models = array();
        $this->_base_classes =& is_loaded();

        $this->_ci_autoloader();
        $CI =& get_instance();

        if ($CI->config->item("gulp_release_mode") == true) {
            $this->_ci_view_paths = [
                APPPATH . 'views_release/' => TRUE,
                APPPATH . 'views/' => TRUE,
            ];
        }
        return $this;
    }

    public function _ci_autoloader()
    {
        if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/autoload.php'))
        {
            include(APPPATH.'config/'.ENVIRONMENT.'/autoload.php');
        }
        else
        {
            include(APPPATH.'config/autoload.php');
        }

        if ( ! isset($autoload))
        {
            return FALSE;
        }

        // Autoload packages
        if (isset($autoload['packages']))
        {
            foreach ($autoload['packages'] as $package_path)
            {
                $this->add_package_path($package_path);
            }
        }

        // Load any custom config file
        if (count($autoload['config']) > 0)
        {
            $CI =& get_instance();
            foreach ($autoload['config'] as $key => $val)
            {
                $CI->config->load($val);
            }
        }

        // Autoload helpers and languages
        foreach (array('helper', 'language') as $type)
        {
            if (isset($autoload[$type]) AND count($autoload[$type]) > 0)
            {
                $this->$type($autoload[$type]);
            }
        }

        // A little tweak to remain backward compatible
        // The $autoload['core'] item was deprecated
        if ( ! isset($autoload['libraries']) AND isset($autoload['core']))
        {
            $autoload['libraries'] = $autoload['core'];
        }

        // Load libraries
        if (isset($autoload['libraries']) AND count($autoload['libraries']) > 0)
        {
            // Load the database driver.
            if (in_array('database', $autoload['libraries']))
            {
                $this->database();
                $autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
            }

            // Load all other libraries
            foreach ($autoload['libraries'] as $item)
            {
                $this->library($item);
            }
        }

        // Autoload models
        if (isset($autoload['model']))
        {
            $this->model($autoload['model']);
        }
    }
}