<?php


class Group extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("group_serv");
        $this->load->library("guest_serv");
        $this->load->library("api_lib");
    }

    public function get()
    {
        $groups = $this->group_serv->getGroups();
        $this->api_lib->output(['groups' => $groups]);
    }
}
