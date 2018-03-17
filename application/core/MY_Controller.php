<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $db_ro;

    function __construct() {
        parent::__construct();

        // $this->db_ro = $this->load->database('read_only', TRUE);
        // $this->db_ro->initialize();

        // $this->load->library('user_serv');

        date_default_timezone_set('Asia/Taipei');
    }

    public function getDB() {
        return $this->db_ro;
    }

}
