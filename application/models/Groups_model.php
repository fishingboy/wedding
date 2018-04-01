<?php

include_once (__DIR__ . "/Model_base.php");

class Groups_model extends Model_base
{
    /**
     * 資料表
     * @var string
     */
    protected $table = "groups";

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

    public function getGroups()
    {
        $groups = $this->CI->db->from("groups")->order_by('id', 'asc')->get()->result_array();
        return $groups;
    }

    public function getGroupName($group_id)
    {
        $group = $this->CI->db->from("groups")->where('id', $group_id)->get()->row_array();
        return $group ? $group['name'] : 'xxx';
    }
}
