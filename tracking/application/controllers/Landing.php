<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function indexna($id){
        $merchant_row = $this->Model_data->merchant_byid($id);
        $data['shopna'] = $merchant_row;

		$this->load->view('index-app', $data);
	}

}
