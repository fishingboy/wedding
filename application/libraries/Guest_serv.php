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
        return $this->CI->guests_model->create($params);
    }
}

