<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webhooks extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->library('shopify');
        $this->load->model('Data_master_m');
    }

    public function index(){
    	$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://apiv2.jne.co.id:10101/tracing/api/pricedev",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_SSL_VERIFYPEER => FALSE,
          CURLOPT_POSTFIELDS => "from=CGK10000&thru=CGK10101&weight=1&username=SEMOHMSE&api_key=7e3bfb8d3fda52e1ffeb9a5c96d506f7",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5"
          ),
        ));

        $response = curl_exec($curl);
        $error_message = curl_error($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        var_dump($error_message);
    }

    public function shop_data_erasure(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');

        $this->db->insert('shop_data_erasure', array('data'=>$data));
    }

    public function customer_data_erasure(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        $this->db->insert('customer_data_erasure', array('data'=>$data));

        echo 'no data collecting';
    }

    public function customer_data_request(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        $this->db->insert('customer_data_request', array('data'=>$data));
        echo 'no data collecting';
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

        $merchant_row = $this->Data_master_m->merchant_row($url_store);

        $datana = array(
            'id_merchant' => $id_store,
            'nama_merchant' => $nama_store,
            'email_merchant' => $email_store,
            'phone_merchant' => $phone_store,
            'url_shopify' => $url_store,
            'create_at' => date('Y-m-d H:i:s')
        );
        var_dump($datana);
        $this->db->insert('uninstall_merchant', $datana);

        $this->db->where('id', $merchant_row->id);
        $this->db->delete('merchant_data');
    }
}
?>