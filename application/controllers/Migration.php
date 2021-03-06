<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Migration 工具
 */
class Migration extends CI_Controller
{
    /**
     * 換行字元
     * @var string
     */
    private $_nl;

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
        $this->load->database();
        $this->load->library('migration');

        // // 判斷換行字元
        $this->_nl = (is_cli()) ? "\n" : "<br>";

        // 限定本機或 Command Line 使用
        if ( ! is_cli() && 
            $_SERVER['REMOTE_ADDR'] != '127.0.0.1' && 
            $_SERVER['REMOTE_ADDR'] != '::1' &&
            false !== strpos($_SERVER['REMOTE_ADDR'], '192.168.')
        ) {
            echo "No Permission !!!";
            exit;
        }

        // 強迫吐錯誤訊息
        error_reporting(-1);
        ini_set('display_errors', 1);
    }

    public function index()
    {
        echo "
migration (資料庫遷移)

php index.php migration          -- 看指令
php index.php migration migrate  -- 執行
php index.php migration rollback -- 回復到前一個 migration
php index.php migration ls       -- 看目前 migration 的狀態

";
    }

    /**
     * 更新到最後版本
     */
    public function migrate()
    {
        $migrations = $this->migration->find_migrations();



        $count = 0;
        foreach ($migrations as $version => $migration) {
            if ($migration['run'] == 0) {
                $version = $migration['version'];
                $this->run($version);
                $count++;
            }
        }

        if ($count == 0) {
            echo "Nothing To Migrate.\n";
        }
        return true;
    }

    /**
     * rollback 到上一版或單獨 rollback 某個 migration
     * @param string $version
     * @return bool
     */
    public function rollback($version = "")
    {
        $migrations = $this->migration->find_migrations();
        krsort($migrations);

        $count = 0;
        if ($version) {
            if ( ! isset($migrations[$version])) {
                echo "你指定的 Migration version 不存在。";
                exit;
            }

            $this->run($version, "down");
            $count++;
        } else {
            foreach ($migrations as $version => $migration) {
                if ($migration['run'] == 1) {
                    $version = $migration['version'];
                    $this->run($version, "down");
                    $count++;
                    break;
                }
            }
        }

        if ($count == 0) {
            echo "Nothing To Rollback.\n";
        }
        return true;
    }

    /**
     * 清空 Migration
     */
    public function reset()
    {
        $migrations = $this->migration->find_migrations();
        krsort($migrations);

        $count = 0;
        foreach ($migrations as $version => $migration) {
            if ($migration['run'] == 1) {
                $version = $migration['version'];
                $this->run($version, "down");
            }
        }
        echo "Migration Reset ............. OK !{$this->_nl}";
        return true;
    }

    /**
     * 重整到最後版本
     */
    public function refresh()
    {
        $this->benchmark->mark('start');

        // 清空資料庫
        $this->reset();

        // 更新到最新版本
        if ( ! $this->migrate()) {
            echo "Migration Refresh Fail!{$this->_nl}";
            return FALSE;
        }
        echo "Migration Refresh ............. OK !{$this->_nl}";
        $this->benchmark->mark('finish');
        echo "總共執行: " .  $this->benchmark->elapsed_time('start', 'finish') . "秒<br>";
    }

    /**
     * 列出所有 migrations
     */
    public function ls()
    {
        $migrations = $this->migration->find_migrations();
        $i = $unfinished = 0;
        echo "     Version         Status  File\n";
        echo "     --------------  ------  ------------------------------------\n";
        foreach ($migrations as $migration) {
            $i++;
            $version = $migration['version'];
            $file = $migration['file'];
            $run = ($migration['run']) ? "ok" : "--";
            echo sprintf("%3d. %s    %s    %s \n", $i, $version, $run, $file) ;

            // 記錄有多少未完成
            if ( ! $migration['run']) {
                $unfinished++;
            }
        }
        echo "     --------------  ------  ------------------------------------\n";
        echo "     有 {$unfinished} 個 Migration 待執行。\n";
    }

    /**
     * 執行 migration
     */
    private function run($version = "", $method = "up")
    {
        if ( ! $version) {
            return false;
        }

        $migrations = $this->migration->find_migrations();
        $file = $migrations[$version]['file'];

        include_once($file);
        $class = 'Migration_'.ucfirst(strtolower($this->_get_migration_name(basename($file, '.php'))));

        // Validate the migration file structure
        if ( ! class_exists($class, FALSE)) {
            $this->_error_string = sprintf($this->lang->line('migration_class_doesnt_exist'), $class);
            return FALSE;
        } elseif ( ! is_callable(array($class, $method))) {
            $this->_error_string = sprintf($this->lang->line('migration_missing_'.$method.'_method'), $class);
            return FALSE;
        }

        // 建立實體
        $migration_obj = new $class();

        // 執行
        $migration_obj->$method();

        echo "Migration Run : {$class}::{$method}() ............. OK !{$this->_nl}";

        $this->migration->update_version([
            'version' => $version,
            'file'    => $file,
            'run'     => 1
        ], $method);            
    }

    protected function _get_migration_name($migration)
    {
        $parts = explode('_', $migration);
        array_shift($parts);
        return implode('_', $parts);
    }
}

/* End of file migration.php */
/* Location: ./application/controllers/migration.php */
