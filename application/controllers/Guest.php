<?php


class Guest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("group_serv");
        $this->load->library("guest_serv");
        $this->load->library("api_lib");
    }

    public function create()
    {
        $name          = $this->api_lib->getParam("name","required");
        $email         = $this->api_lib->getParam("email","required");
        $phone         = $this->api_lib->getParam("phone","required");
        $postal_code   = $this->api_lib->getParam("postal_code","required");
        $address       = $this->api_lib->getParam("address","required");
        $group_id      = $this->api_lib->getParam("group_id","required");
        $peoples       = $this->api_lib->getParam("peoples","required");
        $vegan_peoples = $this->api_lib->getParam("vegan_peoples","required");

        $id = $this->guest_serv->create([
            "name" => $name,
            "phone" => $phone,
            "email" => $email,
            "postal_code" => $postal_code,
            "address" => $address,
            "group_id" => $group_id,
            "peoples" => $peoples,
            "vegan_peoples" => $vegan_peoples,
        ]);
        if ( ! $id) {
            $this->api_lib->outputError(ErrorStack::pop());
        }

        $this->api_lib->output(["id" => $id]);
    }
}
