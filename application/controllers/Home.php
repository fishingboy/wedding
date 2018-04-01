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
        $this->index2();
    }

    public function index1()
    {
        $photos = $this->tool_serv->getPhotos();
        $this->load->view("index_view", ['photos' => $photos]);
    }

    public function index2()
    {
        $photos = $this->tool_serv->getPhotos();
        $this->load->view("index2_view", ['photos' => $photos]);
    }
}
