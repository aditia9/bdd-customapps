<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_data');
    }

    function index(){
    	$this->load->view('index');
    }

	public function install(){
    	$api_key = $this->config->item('api_key');
	    $scopes = $this->config->item('scopes');
	   	$redirect_uri = $this->config->item('redirect_url');
	   	$redirect_scope = $this->config->item('generate_scope');
	   	$redirect_install_lagi = $this->config->item('install_lagi');

    	if ( !empty($_POST) ) {
    		extract($_POST);
	    	// Build install/approval URL to redirect to
			$install_url = "https://" . $urlna . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

			// Redirect
			header("Location: " . $install_url);
    	}else{
    		$params = $_GET; // Retrieve all request parameters
	        $hmac = $_GET['hmac']; // Retrieve HMAC request parameter
	        $urlna = $_GET['shop']; 
	        
        	$merchant_row = $this->Model_data->merchant_row($urlna);
        	
        	if ($merchant_row == NULL) {
        		$install_url = "https://" . $urlna . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

				header("Location: " . $install_url);
        	}else{
        		redirect('landing/indexna/'.$merchant_row->id_merchant);
        	}
    	}
    }

    public function generate_token(){
    	$api_key = $this->config->item('api_key');
		$shared_secret = $this->config->item('shared_secret');
	    
		$headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

    	$params = $_GET; // Retrieve all request parameters
		$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

		$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
		ksort($params); // Sort params lexographically

		$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);
		// Use hmac data to check that the response is from Shopify or not
		if (hash_equals($hmac, $computed_hmac)) {

			// Set variables for our request
			$query = array(
				"client_id" => $api_key, // Your API key
				"client_secret" => $shared_secret, // Your app credentials (secret key)
				"code" => $params['code'] // Grab the access key from the URL
			);

			// Generate access token URL
			$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

			// Configure curl client and execute request
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $access_token_url);
			curl_setopt($ch, CURLOPT_POST, count($query));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
			$result = curl_exec($ch);
			curl_close($ch);

			// Store the access token
			$result = json_decode($result, true);
			$access_token = $result['access_token'];

	        $this->save_merchant($access_token, $params['shop'], $hmac);

			redirect('https://'.$params['shop'].'/admin/apps/track-order-color-box');

		} else {
			// Someone is trying to be shady!
			die('This request is NOT from Shopify!');
		}
    }

    function save_merchant($access_token,$url_shop,$hmac){
    	$api_key = $this->config->item('shopify_api_key');
		$shared_secret = $this->config->item('shopify_secret');
	    $url_shop = $url_shop;
	    $access_token = $access_token;
	    $hmac = $hmac;
		$headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

    	// detail shop
		$shopna = $this->shopify->shopify_call($access_token, $url_shop, "/admin/api/2020-01/shop.json", array(), 'GET', $headerna);
		$datana = $shopna['response'];
	    $shop = json_decode($datana, JSON_PRETTY_PRINT);

	    // Show the access token (don't do this in production!)
		$merchant_data = array(
			'id_merchant' => $shop['shop']['id'],
			'email_merchant' => $shop['shop']['email'],
			'phone_merchant' => $shop['shop']['phone'],
		    'nama_merchant' => $shop['shop']['name'],
		    'alamat_merchant' => $shop['shop']['address1'],
		    'city_merchant' => $shop['shop']['city'],
		    'provinsi_merchant' => $shop['shop']['province'],
		    'country_merchant' => $shop['shop']['country_name'],
		    'url_shopify' => $url_shop,
		    'token_store' => $access_token,
		    'hmac' => $hmac,
		    'create_at' => date('Y-m-d H:i:s'), 
		);

		$this->db->insert('merchant_data', $merchant_data);

		$webhookna = '
        {
            "webhook": {
                "topic": "app/uninstalled",
                "address": "https://bdd.services/tracking-order-colorbox/webhooks/app_uninstall",
                "format": "json"
            }
        }';


        $scriptTag = $this->shopify->api_post($url_shop, "webhooks.json", $access_token, $webhookna);
    }

}
