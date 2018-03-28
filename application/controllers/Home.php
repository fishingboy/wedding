<?php


class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("tool_serv");
    }

    public function index()
    {
        $photos = $this->tool_serv->getPhotos();
        $this->load->view("index_view", ['photos' => $photos]);
    }
}
