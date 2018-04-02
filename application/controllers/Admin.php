<?php


class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("group_serv");
        $this->load->library("guest_serv");
        $this->load->library("api_lib");
        $this->load->config("admin");
        session_start();
    }

    public function index()
    {
        $this->showList();
    }

    public function showList()
    {
        if ( ! isset($_SESSION['auth'])) {
            $this->load->view("login_view", [
                'admin_user' => $this->config->item("admin_user"),
                'admin_password' => $this->config->item("admin_password"),
            ]);
            return false;
        }

        $guests = $this->guest_serv->getGuests();
        $this->load->view("list_view", ['guests' => $guests]);
    }
}
