<?php


class Photo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("api_lib");
        $this->load->library("tool_serv");
    }

    public function get()
    {
        $photos = $this->tool_serv->getPhotos();
        $this->api_lib->output(['photos' => $photos]);
    }
}
