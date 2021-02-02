<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {


	function active_tracking(){
		extract($_POST);
		$shop = $this->Model_data->merchant_row($url_shopify);
		// echo $merchant_row->url_shopify;
		// echo $merchant_row->token_store;
		// die();
		$script_tags = '
        {
          "script_tag": {
            "event": "onload",
            "src": "'.base_url().'/assets/track-order.js"
          }
        }
        ';

        $script_tag = $this->shopify->api_post($shop->url_shopify, "script_tags.json", $shop->token_store, $script_tags);
        $script_tag = json_decode($script_tag, TRUE);
        $id_script_tags = $script_tag['script_tag']['id'];

        $updScript = array(
			'id_script_tags' => $id_script_tags
		);

		$this->db->where('id', $shop->id);
        $this->db->update('merchant_data', $updScript);

        echo $id_script_tags;
	}

	function show_resi(){
		$shop = $this->db->get_where('merchant_data', array('url_shopify' => $_GET["shop"]))->row();
        $id = implode(',', $_GET['ids']);

        $order = $this->shopify->api_get($shop->url_shopify, 'orders.json?status=any&ids='.$id, $shop->token_store);
        $order = json_decode($order, TRUE);

        $data_order = array();
        $order_select = '';
        $order_pending = '';

        if(!empty($order['orders'])){
            foreach ($order['orders'] as $key => $value) {

                if($value['fulfillment_status'] !== null){

                    foreach ($value['fulfillments'] as $d => $l) {
                        $data_order[] = array(
                            'order_id' => $value['id'],
                            'fulfillments' => $value['fulfillment_status'],
                            'order_number' => $value['name'],
                            'order_billing_name' => $value['billing_address']['name'],
                            'order_email' => $value['email'],
                            'order_address' => $value['shipping_address']['address1'].' '.$value['shipping_address']['city'].' '.$value['shipping_address']['province'].' '.$value['shipping_address']['country'].' '.$value['shipping_address']['zip'],
                            'order_resi' => $l['tracking_number'],
                            'order_resi_id' => $l['id']
                        );

                        $order_select .= $value['name']."<br>";
                    }

                }
                else{
                    $order_pending .= $value['name']."<br>";
                }
                
            }
        }
        
        $data['orders'] = $data_order;
        $data['shop'] = $shop;
        $data['selected'] = $order_select;
        $data['pending'] = $order_pending;

        $this->load->view('index-resi', $data);
	}

	function upd_resi(){
		extract($_POST);
    	$shop = $this->db->get_where('merchant_data', array('url_shopify' => $url_shopify))->row();
    	$lengthna = count($order_id);

    	for ($i=0; $i < 2; $i++) { 

    		$orderna = array(
				"fulfillment" => array (
			    	"id" => $fulfill_id[$i],
			    	"tracking_number" => $no_resi[$i]
			  	)
			);
			$this->shopify->shopify_call($shop->token_store, $shop->url_shopify, "/admin/api/2020-04/orders/".$order_id[$i]."/fulfillments/".$fulfill_id[$i].".json", $orderna, 'PUT');
    	}
	}

	function find_order(){
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");

        extract($_POST);
        if ($no_order != null && $email_order != null) {
            $shopna = $this->db->get_where('merchant_data', array('url_shopify' => $shop))->row();

            $endpoint = 'orders.json?status=any&name='.$no_order;

            $orderna = $this->shopify->api_get($shop, $endpoint, $shopna->token_store);
            $orderna = json_decode($orderna, TRUE);

            if($orderna['orders'] != NUll){
                $get_no = '#'.$no_order;
                $emailna = $email_order;
                $kurir = '';

                if($get_no == $orderna['orders'][0]['name'] && $emailna == $orderna['orders'][0]['email']){
                    $data['shopna'] = $shopna;
                    $data['orderna'] = $orderna['orders'][0];

                    if($orderna['orders'][0]['shipping_lines'] != null){
                        $kurir = $orderna['orders'][0]['shipping_lines'][0]['title'];
                    }

                    if($orderna['orders'][0]['fulfillments'] != null){
                        $no_resi = $orderna['orders'][0]['fulfillments'][0]['tracking_number'];
                        $result = $this->shopify->lacak($no_resi);

                        $data['result'] = json_decode($result, TRUE);

                        if($data['result']['result'] == null){
                            $toSmall = strtolower($kurir);

                            if (strpos($toSmall, 'jne') !== false) {
                                $kurirna = "jne";
                            }
                            else if(strpos($toSmall, 'pos') !== false) {
                                $kurirna = "pos";
                            }
                            else if(strpos($toSmall, 'tiki') !== false) {
                                $kurirna = "tiki";
                            }
                            else if(strpos($toSmall, 'wahana') !== false) {
                                $kurirna = "wahana";
                            }
                            else if(strpos($toSmall, 'jnt') !== false) {
                                $kurirna = "jnt";
                            }
                            else if(strpos($toSmall, 'j&t') !== false) {
                                $kurirna = "jnt";
                            }
                            else if(strpos($toSmall, 'rpx') !== false) {
                                $kurirna = "rpx";
                            }
                            else if(strpos($toSmall, 'sap') !== false) {
                                $kurirna = "sap";
                            }
                            else if(strpos($toSmall, 'sicepat') !== false) {
                                $kurirna = "sicepat";
                            }
                            else if(strpos($toSmall, 'jet') !== false) {
                                $kurirna = "jet";
                            }
                            else if(strpos($toSmall, 'dse') !== false) {
                                $kurirna = "dse";
                            }
                            else if(strpos($toSmall, 'first') !== false) {
                                $kurirna = "first";
                            }
                            else if(strpos($toSmall, 'lion') !== false) {
                                $kurirna = "lion";
                            }
                            else if(strpos($toSmall, 'ninja') !== false) {
                                $kurirna = "ninja";
                            }
                            else if(strpos($toSmall, 'idl') !== false) {
                                $kurirna = "idl";
                            }
                            else{
                                $kurirna = $kurir;
                            }

                            $result2 = $this->shopify->lacak_kurir($no_resi, $kurirna);
                            $data['result'] = json_decode($result2, TRUE);

                            if($data['result'] == null){
                                $data['no_resi'] = $no_resi;

                                $data['success'] = $data['result']['success'];

                                $this->template->load('template_front','index-tracking', $data);
                            }
                            else{
                            	$data['success'] = $data['result']['success'];
                                $this->template->load('template_front','index-tracking', $data);
                            }
                        }
                        else{
                        	$data['success'] = $data['result']['success'];
                            $this->template->load('template_front','index-tracking', $data);
                        }
                    }
                    else{
                        $this->template->load('template_front','index-tracking', $data);
                    }

                }
                else{
                    $data = array(
                        'kode' => 'nf',
                        'messages' => "No order and email not found."
                    );
                    echo json_encode($data);
                }
            }
            else{
                $data = array(
                    'kode' => 'nf',
                    'messages' => "No order and email not found."
                );
                echo json_encode($data);
            }
        }
        else{
            $data = array(
                'kode' => 'nf',
                'messages' => "No order or email Can't be blank."
            );
            echo json_encode($data);
        }
	}

}
