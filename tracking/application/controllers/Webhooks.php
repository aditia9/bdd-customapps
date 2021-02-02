<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webhooks extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->library('shopify');
        $this->load->model('Model_data');
    }

    public function index(){
    	echo 'Page not found';
    }

    public function app_uninstall(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        

        $data = json_decode($data, false);
        
        $id_store = $data->id;
        $nama_store = $data->name;
        $email_store = $data->email;
        $url_store = $data->domain;
        $phone_store = $data->phone;

        $merchant_row = $this->Model_data->merchant_row($url_store);
        if ($merchant_row->app_active_at == '0000-00-00 00:00:00') {
            $installed_at = date('Y-m-d H:i:s');
        }else{
            $installed_at = date('Y-m-d H:i:s', strtotime($merchant_row->app_active_at));
        }

        $datana = array(
            'id_merchant' => $id_store,
            'nama_merchant' => $nama_store,
            'email_merchant' => $email_store,
            'phone_merchant' => $phone_store,
            'url_shopify' => $url_store,
            'installed_at' => $installed_at, 
            'create_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('uninstall_merchant', $datana);

        // $to_email = 'app@bolehdicoba.com';
        // //Load email library
        // $this->load->library('email');
        // $this->email->from($merchant_row->email_merchant);
        // $this->email->to($to_email);
        // $this->email->subject('Uninstalled app: '.$url_store);
        // $this->email->message('
        //     Unique Code Transaction App Uninstalled: '.$url_store.'<br />
        //     ');
        // $this->email->send();
        // //Send mail

        // $id_appna = $merchant_row->id_app_charges;
        // $delete_app_charge = $this->shopify->api_delete($url_store, "recurring_application_charges/".$id_appna.".json", $merchant_row->token_store);

        $this->db->where('id', $merchant_row->id);
        $this->db->delete('merchant_data');
    }
}
?>