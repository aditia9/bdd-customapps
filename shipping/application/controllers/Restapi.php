<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . './libraries/Rest_controller.php';

class Restapi extends Rest_controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_get() {
        $id = $this->get('id');
        $kontak = 'tes';
        $this->response($kontak, 200);
    }

}