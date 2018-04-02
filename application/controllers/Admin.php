<?php


class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("group_serv");
        $this->load->library("guest_serv");
        $this->load->library("api_lib");
    }

    public function showList()
    {
        $guests = $this->guest_serv->getGuests();
//        echo "<pre>guests = " . json_encode($guests, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE) . "</pre>";
        $this->load->view("list_view", ['guests' => $guests]);
    }
}
