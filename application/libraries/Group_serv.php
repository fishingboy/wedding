<?php


class Group_serv
{
    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model("groups_model");
    }

    public function getGroups()
    {
        $groups = $this->CI->groups_model->getGroups();
        return $groups;
    }
}

