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
                ErrorStack::push("$field@@@請填寫 [$field_name] 欄位哦，感謝！");
                return false;
            }
        }

        if ($params['peoples'] < 1) {
            ErrorStack::push("peoples@@@請填寫 [出席人數] 欄位哦，感謝！");
            return false;
        }

        if ($params['vegan_peoples'] < 0) {
            ErrorStack::push("vegan_peoples@@@請填寫 [共幾位吃素] 欄位哦，感謝！");
            return false;
        }

        if ($params['vegan_peoples'] > $params['peoples']) {
            ErrorStack::push("peoples@@@ [共幾位吃素] 大於 [出席人數]，你是不是不小心填錯了？");
            return false;
        }

        // 聯絡電話檢查
        $params['phone'] = str_replace("-", "", $params['phone']);
        $params['phone'] = str_replace("(", "", $params['phone']);
        $params['phone'] = str_replace(")", "", $params['phone']);
        $params['phone'] = str_replace(" ", "", $params['phone']);
        if ( ! preg_match("/^[0-9]{10}$/", $params['phone'])) {
            ErrorStack::push("phone@@@ [聯絡電話] 不是 10 碼，你是不是不小心填錯了？");
            return false;
        }

        // 郵遞區號
        $params['postal_code'] = str_replace("-", "", $params['postal_code']);
        $params['postal_code'] = str_replace(" ", "", $params['postal_code']);
        if ( ! preg_match("/^[0-9]+$/", $params['phone'])) {
            ErrorStack::push("postal_code@@@ [郵遞區號] 裡有不是數字的文字，你是不是不小心填錯了？");
            return false;
        }

        if (strlen($params['postal_code']) != 3 && strlen($params['postal_code']) != 5) {
            ErrorStack::push("postal_code@@@ [郵遞區號] 不是 3 碼也不 是 5 碼，你是不是不小心填錯了？ ");
            return false;
        }

        return true;
    }

    public function getGuests()
    {
        $guests = $this->CI->db->from("guests")->order_by('id', 'asc')->get()->result_array();
        return $guests;
    }

    public function getStatistic()
    {
        $guests = $this->CI->db->from("guests")
                 ->join("groups", "guests.group_id=groups.id")
                 ->get()->result_array();
        $total = $peoples = $vegan_peoples = [];
        foreach ($guests as $guest) {
            $relation = $guest['relation'];

            // 填寫人數
            $total['total'] = isset($total['total']) ? $total['total'] + 1 : 1;
            $total[$relation] = isset($total[$relation]) ? $total[$relation] + 1 : 1;

            // 出席人數
            $peoples['total'] = isset($peoples['total']) ? $peoples['total'] + $guest['peoples'] : $guest['peoples'];
            $peoples[$relation] = isset($peoples[$relation]) ? $peoples[$relation] + $guest['peoples'] : $guest['peoples'];

            // 吃素
            $vegan_peoples['total'] = isset($vegan_peoples['total']) ? $vegan_peoples['total'] + $guest['vegan_peoples'] : $guest['vegan_peoples'];
            $vegan_peoples[$relation] = isset($vegan_peoples[$relation]) ? $vegan_peoples[$relation] + $guest['vegan_peoples'] : $guest['vegan_peoples'];
        }

        return [
            'total'         => $total,
            'peoples'       => $peoples,
            'vegan_peoples' => $vegan_peoples,
        ];
    }
}

