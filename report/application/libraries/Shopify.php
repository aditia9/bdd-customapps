<?php

class Shopify {

	public function request($store, $api_key, $api_pass,$end_point){
		
	    $url = 'https://'.$api_key.':'.$api_pass.'@'.$store.'/admin/api/2020-01/'.$end_point;
	    $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_VERBOSE => 1,
            CURLOPT_HEADER => 1
        ));
        $data = curl_exec($curl);
        

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($data, 0, $header_size);
        $body = substr($data, $header_size);

        $data_response = json_decode($body);

        $header_arr = explode("\r\n", $header);
        $next_prev_link = [
            "next" => null,
            "prev" => null,
        ];
        
        foreach ($header_arr as $key => $value) {
            $link = explode(": ", $value);
            if ($link[0] == "link") {
                $link_http = explode(", ", $link[1]);
                foreach ($link_http as $key => $value) {
                    $string = ' ' . $value;
                    $ini = strpos($string, '<');
                    if ($ini == 0) return '';
                    $ini += strlen('<');
                    $len = strpos($string, '>', $ini) - $ini;
                    $link_ku = substr($string, $ini, $len);
                    
                    $store_ = explode("://", $link_ku);
                    if ($store_[0] == "https") {
                        $fix_link        = str_replace(" ", "",str_replace("https://", "https://$api_key:$api_pass@", $link_ku));
                    }else{
                        $fix_link        = str_replace(" ", "",str_replace("http://", "http://$api_key:$api_pass@", $link_ku));
                    }

                    if (strpos($value, "previous")) {
                        $next_prev_link['prev'] = $fix_link;
                    }else{
                        $next_prev_link['next'] = $fix_link;
                    }
                }
            }
        }
        curl_close($curl);
        
        return [
            "data"  => $data_response,
            "link"  => $next_prev_link
        ];
	}

	function api_get($url,$api_endpoint,$token){
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://".$url."/admin/api/2020-04/".$api_endpoint,
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

    function api_delete($url,$api_endpoint,$token){
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://".$url."/admin/api/2020-04/".$api_endpoint,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "DELETE",
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
		CURLOPT_URL => "https://".$url."/admin/api/2020-04/".$api_endpoint,
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
		CURLOPT_URL => "https://".$url."/admin/api/2020-04/".$api_endpoint,
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

    function lacak($no_resi){
    	$curl = curl_init();
		$url_ = "http://api.shipping.esoftplay.com/waybill/".$no_resi;

		curl_setopt_array($curl, array(
		CURLOPT_URL => $url_,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json"
			)
		));

		$response = curl_exec($curl);
		curl_close($curl);
		// echo $response."<br><br><br>";
		return $response;
		
    }
    function lacak_kurir($no_resi, $kurirna){
    	$curl = curl_init();
		$url_ = "http://api.shipping.esoftplay.com/waybill/".$no_resi."/".$kurirna;

		curl_setopt_array($curl, array(
		CURLOPT_URL => $url_,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json"
			)
		));

		$response = curl_exec($curl);
		curl_close($curl);
		// echo $response."<br><br><br>";
		return $response;
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
}