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
        $name          = $this->api_lib->getParam("name");
        $email         = $this->api_lib->getParam("email");
        $phone         = $this->api_lib->getParam("phone");
        $postal_code   = $this->api_lib->getParam("postal_code");
        $address       = $this->api_lib->getParam("address");
        $group_id      = $this->api_lib->getParam("group_id");
        $peoples       = $this->api_lib->getParam("peoples");
        $vegan_peoples = $this->api_lib->getParam("vegan_peoples", null, true, 0);
        $say           = $this->api_lib->getParam("say");

        $id = $this->guest_serv->create([
            "name" => $name,
            "phone" => $phone,
            "email" => $email,
            "postal_code" => $postal_code,
            "address" => $address,
            "group_id" => $group_id,
            "peoples" => $peoples,
            "vegan_peoples" => $vegan_peoples,
            "say" => $say,
        ]);
        if ( ! $id) {
            $this->api_lib->outputError(ErrorStack::pop());
        }

        $this->api_lib->output(["id" => $id]);
    }
}
