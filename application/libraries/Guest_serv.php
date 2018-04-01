<?php


class Guest_serv
{
    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model("guests_model");
        $this->CI->load->model("groups_model");
    }

    public function create($params)
    {
        $status = $this->checkParams($params);
        if ( ! $status) {
            return false;
        }

        $params['group_name'] = $this->CI->groups_model->getGroupName($params['group_id']);
        return $this->CI->guests_model->create($params);
    }

    private function checkParams($params)
    {
        $check_lists = [
            'name' => '姓名',
            // 'email' => 'Email',
            'phone' => '手機',
            'postal_code' => '郵遞區號',
            'address' => '地址',
            'group_id' => '與新人關係',
            'peoples' => '出席人數',
        ];
        foreach ($check_lists as $field => $field_name) {
            if ( ! $params[$field]) {
                ErrorStack::push("$field@@@請填寫 [$field_name] 欄位！");
                return false;
            }
        }
        return true;
    }
}

