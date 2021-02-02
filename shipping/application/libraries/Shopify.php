<?php

class Shopify {

	function tes(){
		return 'tes';
	}

	function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) {
	    
		// Build URL
		$url = "https://" . $shop . $api_endpoint;
		if (!is_null($query) && in_array($method, array('GET', 	'DELETE'))) $url = $url . "?" . http_build_query($query);

		// Configure cURL
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, TRUE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
		// curl_setopt($curl, CURLOPT_SSLVERSION, 3);
		curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

		// Setup headers
		$request_headers[] = "";
		if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
		curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

		if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
			if (is_array($query)) $query = http_build_query($query);
			curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);

			// var_dump(curl_setopt($curl, CURLOPT_POSTFIELDS, $query));
			// die();
		}
	    
		// Send request to Shopify and capture any errors
		$response = curl_exec($curl);
		$error_number = curl_errno($curl);
		$error_message = curl_error($curl);

		// Close cURL to be nice
		curl_close($curl);

		// Return an error is cURL has a problem
		if ($error_number) {
			return $error_message;
		} else {

			// No error, return Shopify's response by parsing out the body and the headers
			$response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

			// Convert headers into an array
			$headers = array();
			$header_data = explode("\n",$response[0]);
			$headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
			array_shift($header_data); // Remove status, we've already set it above
			foreach($header_data as $part) {
				$h = explode(":", $part);
				$headers[trim($h[0])] = trim($h[1]);
			}

			// Return headers and Shopify's response
			return array('headers' => $headers, 'response' => $response[1]);
		}
	}
    

    function graphql($store, $token, $query){
    	
    	$ch = curl_init('https://'.$store.'/admin/api/2019-10/graphql.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'X-Shopify-Access-Token:'.$token
        ));
        // Submit the POST request
        $result = curl_exec($ch);
        // Close cURL session handle
        $data = json_decode($result, true);
        curl_close($ch);
    
        return $data;
    }

    function api_get($url,$api_endpoint,$token){
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://".$url."/admin/api/2020-01/".$api_endpoint,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    "X-Shopify-Access-Token:".$token
			)
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
    }

    function api_post($url,$api_endpoint,$token,$query){
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://".$url."/admin/api/2020-01/".$api_endpoint,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $query,
		CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    "X-Shopify-Access-Token:".$token
			)
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
    }

    function api_put($url,$api_endpoint,$token,$query){
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://".$url."/admin/api/2020-01/".$api_endpoint,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "PUT",
		CURLOPT_POSTFIELDS => $query,
		CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    "X-Shopify-Access-Token:".$token
			)
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
    }

    function jne_get($thru, $weight){

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
		  CURLOPT_POSTFIELDS => "username=COLORBOX&api_key=394bd2a3d041c107a3f11b7e2501b76f&from=BKI10000&thru=".$thru."&weight=".$weight,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/x-www-form-urlencoded",
		    "User-Agent: (Filled with framework request, Ex: Java-Request)"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;

    }

    function upd_fulfillments($order_id, $no_resi){
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://color-box-indo.myshopify.com/admin/api/unstable/orders/".$order_id."/fulfillments.json",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>"{\r\n  \"fulfillment\": {\r\n    \"location_id\": 49351917718,\r\n    \"tracking_number\": \"".$no_resi."\",\r\n    \"notify_customer\": true\r\n  }\r\n}",
		  CURLOPT_HTTPHEADER => array(
		    "X-Shopify-Access-Token: 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",
		    "Content-Type: application/json",
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
    }

    function generate_to_jne($order_id, $receiver_name, $receiver_addr1, $receiver_addr2, $receiver_city, $receiver_zip, $receiver_phone, $qty, $weight, $goodsdesc, $goodsvalue, $ins_flag, $destination, $service){
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://apiv2.jne.co.id:10102/tracing/api/generatecnote',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'username=TESTAPI&api_key=25c898a9faea1a100859ecd9ef674548&OLSHOP_BRANCH=CGK000&OLSHOP_CUST=TESTPO&OLSHOP_ORDERID='.$order_id.'&OLSHOP_SHIPPER_NAME=COLORBOX&OLSHOP_SHIPPER_ADDR1=Jl.%20Raya%20Narogong%20No.12%2C%20RT.007%2FRW.003&OLSHOP_SHIPPER_ADDR2=Bojong%20Rawalumbu&OLSHOP_SHIPPER_CITY=BEKASI&OLSHOP_SHIPPER_ZIP=17116&OLSHOP_SHIPPER_PHONE=62218240445&OLSHOP_RECEIVER_NAME='.$receiver_name.'&OLSHOP_RECEIVER_ADDR1='.$receiver_addr1.'&OLSHOP_RECEIVER_ADDR2='.$receiver_addr1.'&OLSHOP_RECEIVER_CITY='.$receiver_city.'&OLSHOP_RECEIVER_ZIP='.$receiver_zip.'&OLSHOP_RECEIVER_PHONE='.$receiver_phone.'&OLSHOP_QTY='.$qty.'&OLSHOP_WEIGHT='.$weight.'&OLSHOP_GOODSDESC='.$goodsdesc.'&OLSHOP_GOODSVALUE='.$goodsvalue.'&OLSHOP_GOODSTYPE=2&OLSHOP_INS_FLAG='.$ins_flag.'&OLSHOP_ORIG=BKI10000&OLSHOP_DEST='.$destination.'&OLSHOP_SERVICE='.$service.'&OLSHOP_COD_FLAG=N&OLSHOP_COD_AMOUNT=0',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'User-Agent: (Filled with framework request, Ex: Java-Request)'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
    }
}