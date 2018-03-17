<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 檢器狀態檢查
 */  
$config['machine_check'] = [
    /**
     * debug 模式
     */  
    "debug_mode" => true,

    /**
     * show full processlist 裡的 query 數量 (0 代表不檢查)
     */  
    "sql_process_limit" => 10,

    /**
     * php-fpm status 的 "listen queue"  (0 代表不檢查)
     */
    'php_fpm_process_limit' => 1,

    /**
     * php-fpm status 的檢查網址
     */
    'php_fpm_status_url' => "http://localhost/status?json",

    /**
     * 硬碟容量檢查 (留白代表不檢查)
     */
    'storage_check_filesystem' => "/dev/sda1",

    /**
     * 硬碟容量警告上限 (%)
     */
    'storage_check_limit' => 90,

    /**
     * 機器檢查通知的 slack 頻道
     */
    'slack_channel' => "#zuvio-alert",

    /**
     * 監控數字異常時的 retry 次數 (避免只是剛好超過檢查值)
     */
    'retry' => 3,

    /**
     * retry 的時間間隔
     */
    'retry_sleep_sec' => 5,
];