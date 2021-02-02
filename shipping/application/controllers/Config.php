<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->library('shopify');
        $this->load->model('Data_master_m');
    }

    public function generate_resi(){
        extract($_POST);
        $shop = $this->db->get_where('merchant_data', array('url_shopify' => $url_shopify))->row();
        $lengthna = count($order_id);

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        // die();


        for ($i=0; $i < $lengthna; $i++) {
            $generate_resi = $this->shopify->generate_to_jne($order_number[$i], $receiver_name[$i], $address1[$i], $address2[$i], $city[$i], $zip[$i], $phone[$i], $qty[$i], $weight[$i], $goodsdesc[$i], $goodsvalue[$i], $ins_flag[$i], $destination[$i], $service[$i]);

            echo "<pre>";
            echo $generate_resi;
            echo "</pre>";

            // $this->db->update('stt_code', $data);
            // $upd_fulfillment = $this->shopify->upd_fulfillments($order_id[$i], $no_resi[$i]);

            // echo $order_number[$i]." berhasil update, ";
        }
    }

    public function get_generate(){
        $shop = $this->db->get_where('merchant_data', array('url_shopify' => $_GET["shop"]))->row();
        $id = implode(',', $_GET['ids']);

        $order = $this->shopify->api_get($shop->url_shopify, 'orders.json?status=any&ids='.$id, $shop->token_store);
        $order = json_decode($order, TRUE);

        $data_order = array();
        $order_select = '';
        $order_pending = '';
        $qty = 0;
        $destna = $this->db->get('tarif')->result_array();

        // echo "<pre>";
        // var_dump($order['orders'][0]['line_items']);
        // echo "</pre>";
        // die();

        if(!empty($order['orders'])){
            foreach ($order['orders'] as $key => $value) {
                if($value['fulfillment_status'] != 'fulfilled'){

                    foreach ($value['shipping_lines'] as $i => $j) {
                        $shipping = $j['price'];
                    }

                    if($value['shipping_lines'][0]['code'] == 'REG_ASURANSI'){
                        $insurance = 'Y';
                    }
                    else{
                        $insurance = 'N';
                    }

                    $city = strtolower($value['shipping_address']['city']);
                    $kecamatan = strtolower($value['shipping_address']['address2']);
                    $kecamatan_2 = $kecamatan;
                    // echo $kecamatan."=>".$city;
                    // echo "<br>";


                    if (strpos($city, 'kota') !== false) {
                        $city = strtolower(str_replace("kota ", "", $city));
                    }

                    if (strpos($city, 'kab.') !== false) {
                        $city = strtolower(str_replace("kab. ", "", $city));
                        $city = strtolower(str_replace("kab.", "", $city));
                    }

                    if (strpos($city, 'kab') !== false) {
                        $city = strtolower(str_replace("kab ", "", $city));
                    }

                    if (strpos($city, 'tanggerang') !== false) {
                        $city = strtolower(str_replace("tanggerang", "tangerang", $city));
                    }

                    if (strpos($city, 'kabupaten') !== false) {
                        $city = strtolower(str_replace("kabupaten ", "", $city));
                    }

                    if (strpos($kecamatan, 'kapuk muara') !== false) {
                        $kecamatan = strtolower(str_replace("kapuk muara", "penjaringan", $kecamatan));
                    }

                    if (strpos($kecamatan, 'kec ') !== false) {
                        $kecamatan = strtolower(str_replace("kec ", "", $kecamatan));
                    }

                    if (strpos($kecamatan, 'kecamatan ') !== false) {
                        $kecamatan = strtolower(str_replace("kecamatan ", "", $kecamatan));
                    }

                    if (strpos($kecamatan, 'kec.') !== false) {
                        $kecamatan = strtolower(str_replace("kec.", "", $kecamatan));
                    }

                    if (strpos($kecamatan, 'kec. ') !== false) {
                        $kecamatan = strtolower(str_replace("kec. ", "", $kecamatan));
                    }

                    if (strpos($kecamatan, 'pasar kamis') !== false) {
                        $kecamatan = strtolower(str_replace("kamis", "kemis", $kecamatan));
                    }

                    if (strpos($kecamatan, ',') !== false) {
                        $kecamatan = strtolower(str_replace(" ", "", $kecamatan));
                        $kecamatan = substr($kecamatan, strpos($kecamatan, ',') + 1);

                        $kecamatan_2 = strtolower(str_replace(" ", "", $kecamatan_2));
                        $kecamatan_2 = substr($kecamatan_2, 0, strpos($kecamatan_2, ","));
                    }


                    // $kecamatan = substr($kecamatan, 0, strpos($kecamatan, "("));

                    // echo $kecamatan."=>".$city;
                    // echo "<br>";
                    // echo $kecamatan_2;

                    $destination = $this->db->get_where('tarif', array('subdistrict' => $kecamatan, 'city' => $city))->row();

                    $destination_2 = $this->db->query("SELECT * FROM `tarif` WHERE (subdistrict LIKE '%".$kecamatan."%' AND city LIKE '%".$city."%')")->row();

                    if($destination == null){
                        if($destination_2 == null){
                            $kecamatan = strtolower(str_replace(" ", "", $kecamatan));
                            $kecamatan_2 = strtolower(str_replace(" ", "", $kecamatan_2));
                            foreach ($destna as $i => $j) {
                                $j['subdistrict'] = strtolower(str_replace(" ", "", $j['subdistrict']));
                                if(strpos(strtolower($j['subdistrict']), strtolower($kecamatan)) !== false){
                                    // echo $j['subdistrict'];
                                    $destination = $j['destination_code'];
                                    break;
                                }
                                else{
                                    if(strpos(strtolower($j['subdistrict']), strtolower($kecamatan_2)) !== false){
                                        $destination = $j['destination_code'];
                                        break;
                                    }
                                    else{
                                        $destination = '';
                                        continue;
                                    }
                                }
                            }
                        }
                        else{
                            $destination = $destination_2->destination_code;
                        }
                    }
                    else{
                        $destination = $destination->destination_code;
                    }

                    foreach ($value['line_items'] as $h => $i) {
                        $qty += $i['quantity'];
                    }

                    $total_berat = ($value['total_weight'] / 1000);
        
                    if ($total_berat < 0) {
                        $total_berat = 0;
                    }elseif ($total_berat <= 1.3) {
                        $total_berat = 1;
                    }
                    elseif($total_berat > 1.3 && $total_berat < 2.3){
                        $total_berat = 2;
                    }
                    else{
                        $total_berat = round($total_berat,0);
                    }

                    $data_order[] = array(
                        'order_id' => $value['id'],
                        'email' => $value['email'],
                        'order_number' => $value['order_number'],
                        'receiver_name' => $value['shipping_address']['name'],
                        'address1' => $value['shipping_address']['address1'],
                        'address2' => ucfirst($kecamatan),
                        'city' => ucfirst($city),
                        'zip' => $value['shipping_address']['zip'],
                        'phone' => $value['shipping_address']['phone'],
                        'qty' => $qty,
                        'weight' => $total_berat,
                        'goodsdesc' => 'tes',
                        'goodsvalue' => str_replace(".00", "", $value['total_price']),
                        'goodstype' => 2,
                        'ins_flag' => $insurance,
                        'origin' => 'BKI10000',
                        'destination' => $destination,
                        'service' => 'REG',
                        'cod_flag' => 'N',
                        'cod_amount' => 0
                    );
                }
            }
        }
        
        
        $array_response = array();

        // echo "<pre>";
        // var_dump($data_order);
        // echo "</pre>";

        foreach ($data_order as $key => $value) {
            $generate_resi = $this->shopify->generate_to_jne($value['order_id'], $value['receiver_name'], $value['address1'], $value['address2'], $value['city'], $value['zip'], $value['phone'], $value['qty'], $value['weight'], $value['goodsdesc'], $value['goodsvalue'], $value['ins_flag'], $value['destination'], $value['service']);
            // $generate_resi = '{
            //   "detail" : [ {
            //     "status" : "sukses",
            //     "cnote_no" : "0100792004443694"
            //   } ]
            // }';
            $generate_resi = json_decode($generate_resi, true);

            // echo "<pre>";
            // var_dump($generate_resi);
            // echo "</pre>";

            if($generate_resi['detail'][0]['status'] == 'sukses'){
                $array_response[] = array(
                    'order_number' => $value['order_number'],
                    'response' => "Sukses",
                    'resi' => $generate_resi['detail'][0]['cnote_no']
                );

                // $upd_fulfillment = $this->shopify->upd_fulfillments($value['order_id'], $generate_resi['detail'][0]['cnote_no']);
            }
            else{
                $array_response[] = array(
                    'order_number' => $value['order_number'],
                    'response' => "Eror, ".$generate_resi['detail'][0]['reason'],
                    'resi' => ''
                );
            }
        }

        $data['response'] = $array_response;
        $data['shop'] = $shop;

        $this->template->load('template_config','config/generate_resi', $data);
    }

    public function tes_full(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        $this->db->insert('tes', array(
            'datana' => $data,
            'id_variant' => 'tes_fullfilment - ngetesnarrative',
            'create_at' => date('Y-m-d H:i:s')
        ));
    }

    public function app_config(){
        parse_str($_SERVER['QUERY_STRING'], $outputArray);
        $data['merchant_row'] = $this->Data_master_m->merchant_row($outputArray['shop']);
        
        $date = date('2020-06-15');
        //echo date('N', strtotime($date));
        $this->template->load('template_config','config/app_config', $data);
    }

    public function app_config_first($id_shop){
        $merchant_row = $this->Data_master_m->merchant_byid($id_shop);
        $data_shipping = '
            {
              "carrier_service": {
                "name": "JNE Delami Server",
                "callback_url": "https://bdd.delamibrands.com/shipping/front/insert_tes",
                "service_discovery": true
              }
            }
        ';

        $post_shipping = $this->shopify->api_post($merchant_row->url_shopify,'carrier_services.json',$merchant_row->token_store,$data_shipping );
        $post_shipping = json_decode($post_shipping, TRUE);
        
        if (array_key_exists('errors', $post_shipping) == TRUE) {
            var_dump($post_shipping['errors']);
            //echo '<a href="'.base_url().'config/non_aktif">App Active!</a>';
        }else{
            $this->db->where('id', $merchant_row->id);
            $this->db->update('merchant_data', array(
                'id_shipping' => $post_shipping['carrier_service']['id']
            ));    
        }

        //$data['raffle_list'] = $this->Data_master_m->raffle_list();
        
        $date = date('2020-06-15');
        //echo date('N', strtotime($date));
    }

    public function subsidi_ongkir(){
        extract($_POST);

        $this->db->where('id_merchant',$url_shopify);
        $this->db->update('merchant_data', array(
            'minimum_order' => $minimum_order,
            'subsidi_ongkir' => $subsidi_ongkir
        ));

        redirect('config/setting_product/'.$url_shopify);
    }

    public function setting_product($id_merchant){
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        $data['merchant_row'] = $this->Data_master_m->merchant_byid($id_merchant);

        $this->template->load('template_config','config/service', $data);
    }

    public function reg(){
        extract($_POST);

        $merchant_row = $this->Data_master_m->merchant_byid($url_shopify);
        $recent_service = $merchant_row->servicena;
        $ex_recent_service = explode(',', $recent_service);
        if ($mode == 'false') {
            $upd_service = array_diff( $ex_recent_service, ['reg'] );
            $servicena = implode(',', $upd_service);
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $servicena
            ));
        }else{
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $recent_service .= ',reg'
            ));
        }

        echo 'REG updated';
    }

    public function reg_asuransi(){
        extract($_POST);

        $merchant_row = $this->Data_master_m->merchant_byid($url_shopify);
        $recent_service = $merchant_row->servicena;
        $ex_recent_service = explode(',', $recent_service);
        if ($mode == 'false') {
            $upd_service = array_diff( $ex_recent_service, ['reg_asuransi'] );
            $servicena = implode(',', $upd_service);
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $servicena
            ));
        }else{
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $recent_service .= ',reg_asuransi'
            ));
        }

        echo 'REG Asuransi updated';
    }

    public function yes(){
        extract($_POST);

        $merchant_row = $this->Data_master_m->merchant_byid($url_shopify);
        $recent_service = $merchant_row->servicena;
        $ex_recent_service = explode(',', $recent_service);
        if ($mode == 'false') {
            $upd_service = array_diff( $ex_recent_service, ['yes'] );
            $servicena = implode(',', $upd_service);
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $servicena
            ));
        }else{
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $recent_service .= ',yes'
            ));
        }

        echo 'YES updated';
    }

    public function yes_asuransi(){
        extract($_POST);

        $merchant_row = $this->Data_master_m->merchant_byid($url_shopify);
        $recent_service = $merchant_row->servicena;
        $ex_recent_service = explode(',', $recent_service);
        if ($mode == 'false') {
            $upd_service = array_diff( $ex_recent_service, ['yes_asuransi'] );
            $servicena = implode(',', $upd_service);
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $servicena
            ));
        }else{
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $recent_service .= ',yes_asuransi'
            ));
        }

        echo 'YES Asuransi updated';
    }

    public function sps(){
        extract($_POST);

        $merchant_row = $this->Data_master_m->merchant_byid($url_shopify);
        $recent_service = $merchant_row->servicena;
        $ex_recent_service = explode(',', $recent_service);
        if ($mode == 'false') {
            $upd_service = array_diff( $ex_recent_service, ['sps'] );
            $servicena = implode(',', $upd_service);
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $servicena
            ));
        }else{
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $recent_service .= ',sps'
            ));
        }

        echo 'SPS updated';
    }

    public function sps_asuransi(){
        extract($_POST);

        $merchant_row = $this->Data_master_m->merchant_byid($url_shopify);
        $recent_service = $merchant_row->servicena;
        $ex_recent_service = explode(',', $recent_service);
        if ($mode == 'false') {
            $upd_service = array_diff( $ex_recent_service, ['sps_asuransi'] );
            $servicena = implode(',', $upd_service);
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $servicena
            ));
        }else{
            $this->db->where('id_merchant', $url_shopify);
            $this->db->update('merchant_data', array(
                'servicena' => $recent_service .= ',sps_asuransi'
            ));
        }

        echo 'SPS Asuransi updated';
    }

    public function save_waktu(){
        extract($_POST);
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);

        $this->db->where('id', $merchant_row->id);
        $this->db->update('merchant_data', array(
            'waktu_ac' => $waktu
        ));
        

        var_dump($_POST);
    }

    public function ac_active(){
        extract($_POST);
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);
        if ($mode == "true") {
            $this->db->where('id', $merchant_row->id);
            $this->db->update('merchant_data', array(
                'ac_active' => 1
            ));
        }else{
            $this->db->where('id', $merchant_row->id);
            $this->db->update('merchant_data', array(
                'ac_active' => 0
            ));
        }

        var_dump($_POST);
    }

    public function pn_active(){
        extract($_POST);
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);
        if ($mode == "true") {
            $this->db->where('id', $merchant_row->id);
            $this->db->update('merchant_data', array(
                'notification_paid' => 1
            ));
        }else{
            $this->db->where('id', $merchant_row->id);
            $this->db->update('merchant_data', array(
                'notification_paid' => 0
            ));
        }

        var_dump($_POST);
    }

    public function save_config(){
        extract($_POST);

        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);

        $list_bank = explode(PHP_EOL, $bankna);

        $bankna_ = array();
        for ($i=0; $i < sizeof($list_bank); $i++) { 
            $bankna_[] = "'".trim($list_bank[$i])."'";
        }
        
        if ($merchant_row->id_page == 0) {
            $data_page = '
            {
              "page": {
                "title": "'.$titlena.'",
                "body_html": "<script>var bankna = ['.implode(',', $bankna_).']; var token_store=\''.$merchant_row->token_store.'\';</script><div id=\'bdd-paid-confirmation\'></div>"
              }
            }
            ';
            

            $page = $this->shopify->api_post($merchant_row->url_shopify, "pages.json", $merchant_row->token_store, $data_page);
            $page = json_decode($page, TRUE);
            
            $id_page = $page['page']['id'];
            $data_script_tags = '
            {
              "script_tag": {
                "event": "onload",
                "src": "'.base_url().'/assets/js-shopify/script.js"
              }
            }
            ';

            $script_tag = $this->shopify->api_post($merchant_row->url_shopify, "script_tags.json", $merchant_row->token_store, $data_script_tags);
            $script_tag = json_decode($script_tag, TRUE);
            $id_script_tags = $script_tag['script_tag']['id'];
            
            $page_save = array(
                'id_page' => $page['page']['id'],
                'id_script_tags' => $script_tag['script_tag']['id'],
                'email_notification' => $email_notification,
                'titlena' => $titlena,
                'contentna' => $contentna,
                'bankna' => $bankna
            );

            $this->db->where('id', $merchant_row->id);
            $this->db->update('merchant_data', $page_save);
            echo '1';
        }else{
            $page_save = array(
                'email_notification' => $email_notification,
                'titlena' => $titlena,
                'contentna' => $contentna,
                'bankna' => $bankna
            );

            $this->db->where('id', $merchant_row->id);
            $this->db->update('merchant_data', $page_save);
            echo '1';
        }
    }

    public function index(){
    	var_dump($q);
    }

    public function product(){
    	parse_str($_SERVER['QUERY_STRING'], $outputArray);
        $merchant_row = $this->Data_master_m->merchant_row($outputArray['shop']);
        $token = $merchant_row->token_store;

    	$products = $this->shopify->shopify_call($outputArray['shop'], "/admin/products.json", array(), 'GET');

		// Convert product JSON information into an array
		
		$produkna = json_decode($products['response'], TRUE);
		$data['produkna'] = $produkna['products'];
        // var_dump($data['produkna']);
        // die();
		//$tes = json_decode($produkna['products'], JSON_PRETTY_PRINT);
		
    	$this->template->load('template_config','config/products', $data);
    }

    public function openapp(){
        var_dump($_SERVER);
        die();
        parse_str($_SERVER['QUERY_STRING'], $outputArray);
        $merchant_row = $this->Data_master_m->merchant_row($outputArray['shop']);
        redirect('config/setting_product/'.$merchant_row->id_merchant);
        
    }

    public function filter_list(){
        extract($_POST);

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['id_merchant'] = $id_merchant;
        $data['all_confirm_paid'] = $this->Data_master_m->filter_confirm_paid($id_merchant,date('Y-m-d', strtotime($from_date)),date('Y-m-d', strtotime($to_date)));

        $this->template->load('template_config','config/paid_confirm_filter', $data);
    }

    public function save_variant(){
        extract($_POST);
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);

        $datana = array(
            'id_variant' => $id_variant,
        );
        $this->db->where('id', $merchant_row->id);
        $this->db->update('merchant_data', $datana);
    }

    public function product_add(){
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        $token = 'e1675dacf618bd52eed6fd753e9f16f1';
        parse_str($_SERVER['QUERY_STRING'], $outputArray);

        $queryna = "{\r\n  \"product\": {\r\n    \"title\": \"kode unik151\",\r\n    \"variants\": [{\r\n        \"price\": \"134\"\r\n    }],\r\n    \"tags\": [\r\n      \"hidden-produk\",\r\n      \"hide\",\r\n      \"\\\"Big Air\\\"\"\r\n    ]\r\n  }\r\n}";

        // $queryna = json_encode($queryna); 
        $products = $this->shopify->apina($outputArray['shop'], "/admin/api/2019-10/products.json", $token , $queryna ,'POST');

        //$produkna = json_decode($products['response'], TRUE);
        var_dump($products);
    }

    public function product_edit_price(){
        
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        $token = 'e1675dacf618bd52eed6fd753e9f16f1';
        parse_str($_SERVER['QUERY_STRING'], $outputArray);

        $harganya = sprintf("%03d", mt_rand(1, 999));
        $queryna = "{\r\n    \"variant\": {\r\n        \"price\": \"".$harganya."\",\r\n        \"inventory_policy\": \"deny\",\r\n        \"compare_at_price\": null,\r\n        \"fulfillment_service\": \"manual\",\r\n        \"inventory_management\": null,\r\n        \"taxable\": false\r\n    }\r\n}";
        
        $kode_variant = '32137995288664';
        // $queryna = json_encode($queryna); 
        $products = $this->shopify->apina($outputArray['shop'], "/admin/api/2020-01/variants/".$kode_variant.".json", $token , $queryna ,'PUT');

        //$produkna = json_decode($products['response'], TRUE);
        var_dump($products);
    }

    function send_request_mail(){
        extract($_POST);
        $to_email = 'app@bolehdicoba.com';
        //Load email library
        $this->load->library('email');
        $this->email->from($email_merchant);
        $this->email->to($to_email);
        $this->email->subject('Request Installation Unique Code Apps');
        $this->email->message('Shopify URL: '.$url_shopify);
        //Send mail
        if($this->email->send()){
            echo 1;
        }

    }
    function add_product_handle(){
        extract($_POST);
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);
        $token = $merchant_row->token_store;

        $products = $this->shopify->apina($url_shopify, "/admin/api/2019-10/products.json", $token , array() ,'GET');
        $products = json_decode($products, TRUE);
        $products = $products['products'];

        $cek_handle = array_search($product_handle, array_column($products, 'handle'));
        if ($cek_handle != NULL) {
            $product_variant = $this->shopify->apina($url_shopify, "/admin/api/2019-10/products/".$products[$cek_handle]['id'].".json", $token , array() ,'GET');
            $product_variant = json_decode($product_variant, TRUE);
            $product_variant = $product_variant['product']['variants'];
            $this->db->where('id', $merchant_row->id);
            $this->db->update('merchant_data', array(
                'id_variant' => $product_variant[0]['id']
            ));
            echo $product_variant[0]['id'];
        }else{
            echo 0;
        }
    }
}
?>