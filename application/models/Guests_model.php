<?php

include_once (__DIR__ . "/Model_base.php");

class Guests_model extends Model_base
{
    /**
     * 資料表
     * @var string
     */
    protected $table = "guests";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 新增資料的驗證
     * @param $params
     * @return bool
     */
    protected function verifyBeforeCreate(& $params)
    {
        $status = $this->verifyParams($params, [
            "name"                 =>  "required",
        ]);
        if (!$status) {
            return false;
        }

        return true;
    }

    /**
     * 更新資料的驗證
     */
    protected function verifyBeforeUpdate( & $params)
    {
        return true;
    }
}
