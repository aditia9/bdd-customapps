<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->model('Login_m');
        $this->load->model('Data_master_m');
    	$this->load->library('session');
    }

    public function get_province(){
    	//$tariff = $this->shopify->sicepat_get('tariff?origin=BDO&destination=BDO10000&weight=1');
    	$destination = $this->shopify->sicepat_get('destination');
    	$destination = json_decode($destination, TRUE);
    	$lokal = array();

    	foreach ($destination['sicepat']['results'] as $key => $value) {
    		$lokal[$value['province']][0] = $value['province'];
    	}
    	$province = array();
    	foreach ($lokal as $key => $value) {
    		echo $province[] = $value[0].'<br />';
    	}
    }

    public function update_rate(){
    	$destination = $this->shopify->sicepat_get('destination');
    	$destination = json_decode($destination, TRUE);
    	$lokal = array();
    	$destination_code = array();
    	$tariff = array();
    	foreach ($destination['sicepat']['results'] as $key => $value) {
    		if ($value['province'] == 'MALUKU') {    			
    			$tarif[$key] = $this->shopify->sicepat_get('tariff?origin=CGK&destination='.$value['destination_code'].'&weight=1');
    		
    			$tariff[$key] = json_decode($tarif[$key], false);
    			$tariff[] = $tariff[$key]->sicepat->status;
    			$destination_code[] = "'".$value['destination_code']."'";
    		}
    	}

    	var_dump($tariff);

    	$im_destination =implode(',', $destination_code);
    	//var_dump($this->Data_master_m->get_rate($im_destination));
    }

    public function insert_tes_asli(){
    	$id_merchant = '42391208086';
    	// cari aktif service
        $merchant_row = $this->Data_master_m->merchant_byid($id_merchant);
        $list_service = explode(',', $merchant_row->servicena);
        $aktif_service = [];
        foreach ($list_service as $key => $value) {
        	if ($value != '') {
        		$aktif_service[] = strtoupper($value); 
        	}
        }

        // echo $merchant_row->url_shopify;

        header('Access-Control-Allow-Origin: *');
    	header('Content-Type: application/json');
        $datana = file_get_contents('php://input');
        // $this->db->insert('tes', array(
        // 	'datana' => $datana,
        // 	'id_variant' => 'tess',
        // 	'create_at' => date('Y-m-d H:i:s')
        // ));
    	// $datana = '
     //    {"rate":
     //        {
     //        "origin":{
     //            "country":"ID",
     //            "postal_code":"40113",
     //            "province":"JB",
     //            "city":"Bandung",
     //            "name":null,
     //            "address1":"15 Jalan Lombok",
     //            "address2":"",
     //            "address3":null,
     //            "phone":"",
     //            "fax":null,
     //            "email":null,
     //            "address_type":null,
     //            "company_name":"ngetes-narrative"
     //        },
     //        "destination":{
     //            "country":"ID",
     //            "postal_code":"40175",
     //            "province":"JB",
     //            "city":"Bandung",
     //            "name":"Aditya Sholahudin",
     //            "address1":"jakarta",
     //            "address2":"cicendo",
     //            "address3":null,
     //            "phone":"0812-8827-866",
     //            "fax":null,
     //            "email":"aditya@bolehdicoba.com",
     //            "address_type":null,
     //            "company_name":null
     //        },
     //        "items":[{
     //            "name":"Product 1 (A) - L \/ Red",
     //            "sku":"","quantity":2,
     //            "grams":400,
     //            "price":20000000,
     //            "vendor":"ngetes-narrative",
     //            "requires_shipping":true,
     //            "taxable":true,
     //            "fulfillment_service":"manual",
     //            "properties":{},
     //            "product_id":4603620819032,
     //            "variant_id":32807995015256
     //        },
     //        {
     //            "name":"Product 1 (A) - L \/ Red",
     //            "sku":"","quantity":2,
     //            "grams":400,
     //            "price":25000000,
     //            "vendor":"ngetes-narrative",
     //            "requires_shipping":true,
     //            "taxable":true,
     //            "fulfillment_service":"manual",
     //            "properties":{},
     //            "product_id":4603620819032,
     //            "variant_id":32807995015256
     //        }],
     //        "currency":"IDR","locale":"en"}}';

        // echo $datana;
        
        $datana = json_decode($datana, TRUE);
        if ($datana['rate']['destination']['city'] == 'jaksel') {
        	$city = 'jakarta selatan';
        }elseif ($datana['rate']['destination']['city'] == 'jakbar') {
        	$city = 'jakarta barat';
        }elseif ($datana['rate']['destination']['city'] == 'jaktim') {
        	$city = 'jakarta timur';
        }elseif ($datana['rate']['destination']['city'] == 'jakpus') {
        	$city = 'jakarta pusat';
        }elseif ($datana['rate']['destination']['city'] == 'tangsel') {
        	$city = 'tangerang selatan';
       	}else{
        	$city = $datana['rate']['destination']['city'];
        }

        // cari data berat produk
        $total_berat = 0;
        $total_price_produk = 0;
        foreach ($datana['rate']['items'] as $key => $value) {
        	$jml_berat = $value['grams'] * $value['quantity'];
        	$total_berat += ($jml_berat / 1000);
        	$total_price_produk += $value['price'];
        }

        $total_price_produk = substr($total_price_produk, 0, -2);

        if ($merchant_row->subsidi_ongkir > 0) {
        	if ($total_price_produk > $merchant_row->minimum_order) {
	        	$subsidi = $merchant_row->subsidi_ongkir;
        	}else{
        		$subsidi = 0;
        	}
        }else{
        	$subsidi = 0;
        }

        // echo $subsidi;

        // tentukan berat produk
        if ($total_berat < 0) {
        	$total_berat = 0;
        }elseif ($total_berat < 1) {
        	$total_berat = 1;
        }else{
        	$total_berat = round($total_berat,0);
        }


    	$destination = $this->db->get('tarif')->result_array();
    	$lokal = array();
    	$destination_code = array();
    	$tariff = array();

        $reg_asuransi = '';
        $yes_asuransi = '';
        $sps_asuransi = '';
        $with_asuransi = '';


        // $kota = strtolower($city);

        // $depok = 'depok';
        // $pos_depok = strpos($kota, $depok);

        // $tangerang = 'tangerang';
        // $pos_tangerang = strpos($kota, $tangerang);
        
        // $bogor = 'bogor';
        // $pos_bogor = strpos($kota, $bogor);

        // $bekasi = 'bekasi';
        // $pos_bekasi = strpos($kota, $bekasi);

        // echo "kota : ".$kota."<br>";

        // echo "depok ".$pos_depok;
        // echo "tangerang ".$pos_tangerang;
        // echo "bogor ".$pos_bogor;
        // echo "bekasi ".$pos_bekasi;

    	if ($total_berat != 0) { // jika berat tidak 0
            
            foreach ($destination as $key => $value) { // tampilkan seluruh data destinasi
                // jika kota dan kecamatan nya udah sesuai

                if (strpos(strtolower($value['city']), strtolower($city)) !== false && strpos(strtolower($value['subdistrict']), strtolower($datana['rate']['destination']['address2'])) !== false ) {
                    // echo $value['destination_code'];
                    // tampilkan data tarif
                    $tarif = $this->shopify->jne_get($value['destination_code'], 1);
                    $tarifna = json_decode($tarif, true);
                    // jika tarif ditemukan
                    if ($tarifna['price'] != null) {
                        // cari tarif berdasarkan service yang aktif
                        foreach ($tarifna['price'] as $x => $y) {
                            foreach ($aktif_service as $as => $aktif) {
                                if ($aktif == $y['service_display']) {

                                    if ($y['service_display'] == 'REG') {
                                        $total_price = $y['price'] * $total_berat - $subsidi;
                                        if ($subsidi > 0) {
                                            $desk = $y['etd_from'].' - '.$y['etd_thru'].' hari (Weight: '.$total_berat.'Kg), Kamu mendapat potongan ongkir '.number_format($subsidi);
                                        }else{
                                            $desk = $y['etd_from'].' - '.$y['etd_thru'].' hari (Weight: '.$total_berat.'Kg)';
                                        }
                                    }else{
                                        $desk = $y['etd_from'].' - '.$y['etd_thru'].' hari (Weight: '.$total_berat.'Kg)';
                                        $total_price = $y['price'] * $total_berat;
                                    }

                                    $total_price .= "00";
                                    // }
                                    // echo $y['price']."=>".$y['service_code']." ";

                                    $tariff[] = array(
                                        'service_name' => 'JNE - '.$y['service_display'],
                                        'service_code' => 'JNE_REG',
                                        'description' => $desk,
                                        'total_price' => $total_price,
                                        'currency' => 'IDR'
                                    );
                                }
                            }
                        }
                    }
                    // jika tarif ditemukan hentikan looping
                    break;
                }else{
                    // jika tarif tidak ditemukan lanjutkan looping
                    continue;
                }

            }

            // ubah data tarif ke json sesuaikan dengat format yg diharuskan sama shopify
            $show_tarif = trim(json_encode($tariff), '[]');
            $data_ = '{
                "rates":[
                    '.$show_tarif.'
                ]
            }';
            
            echo $data_;
        }else{
            echo 'Weight NULL';
        }

    	// $im_destination =implode(',', $destination_code);
    	//var_dump($this->Data_master_m->get_rate($im_destination));
    }

    public function insert_tes(){
        $id_merchant = '42391208086';
        // cari aktif service
        $merchant_row = $this->Data_master_m->merchant_byid($id_merchant);
        $list_service = explode(',', $merchant_row->servicena);
        $aktif_service = [];
        foreach ($list_service as $key => $value) {
            if ($value != '') {
                $aktif_service[] = strtoupper($value); 
            }
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $datana = file_get_contents('php://input'); 

        // $datana = '
        // {"rate":
        //     {
        //     "origin":{
        //         "country":"ID",
        //         "postal_code":"40113",
        //         "province":"JB",
        //         "city":"Bandung",
        //         "name":null,
        //         "address1":"15 Jalan Lombok",
        //         "address2":"",
        //         "address3":null,
        //         "phone":"",
        //         "fax":null,
        //         "email":null,
        //         "address_type":null,
        //         "company_name":"ngetes-narrative"
        //     },
        //     "destination":{
        //         "country":"ID",
        //         "postal_code":"40175",
        //         "province":"JB",
        //         "city":"Jakarta",
        //         "name":"Aditya Sholahudin",
        //         "address1":"jakarta",
        //         "address2":"gambir",
        //         "address3":null,
        //         "phone":"0812-8827-866",
        //         "fax":null,
        //         "email":"aditya@bolehdicoba.com",
        //         "address_type":null,
        //         "company_name":null
        //     },
        //     "items":[{
        //         "name":"Product 1 (A) - L \/ Red",
        //         "sku":"","quantity":2,
        //         "grams":400,
        //         "price":20000000,
        //         "vendor":"ngetes-narrative",
        //         "requires_shipping":true,
        //         "taxable":true,
        //         "fulfillment_service":"manual",
        //         "properties":{},
        //         "product_id":4603620819032,
        //         "variant_id":32807995015256
        //     },
        //     {
        //         "name":"Product 1 (A) - L \/ Red",
        //         "sku":"","quantity":2,
        //         "grams":400,
        //         "price":25000000,
        //         "vendor":"ngetes-narrative",
        //         "requires_shipping":true,
        //         "taxable":true,
        //         "fulfillment_service":"manual",
        //         "properties":{},
        //         "product_id":4603620819032,
        //         "variant_id":32807995015256
        //     }],
        //     "currency":"IDR","locale":"en"}}';

        // echo $datana;
        
        $datana = json_decode($datana, TRUE);
        if ($datana['rate']['destination']['city'] == 'jaksel') {
            $city = 'jakarta selatan';
        }elseif ($datana['rate']['destination']['city'] == 'jakbar') {
            $city = 'jakarta barat';
        }elseif ($datana['rate']['destination']['city'] == 'jaktim') {
            $city = 'jakarta timur';
        }elseif ($datana['rate']['destination']['city'] == 'jakpus') {
            $city = 'jakarta pusat';
        }elseif ($datana['rate']['destination']['city'] == 'tangsel') {
            $city = 'tangerang selatan';
        }else{
            $city = $datana['rate']['destination']['city'];
        }

        // cari data berat produk
        $total_berat = 0;
        $total_price_produk = 0;
        foreach ($datana['rate']['items'] as $key => $value) {
            $jml_berat = $value['grams'] * $value['quantity'];
            $total_berat += ($jml_berat / 1000);
            $total_price_produk += $value['price'];
        }

        $total_price_produk = substr($total_price_produk, 0, -2);

        if ($merchant_row->subsidi_ongkir > 0) {
            if ($total_price_produk > $merchant_row->minimum_order) {
                $subsidi = $merchant_row->subsidi_ongkir;
            }else{
                $subsidi = 0;
            }
        }else{
            $subsidi = 0;
        }

        if ($total_berat < 0) {
            $total_berat = 0;
        }elseif ($total_berat < 1) {
            $total_berat = 1;
        }else{
            $total_berat = round($total_berat,0);
        }


        $destination = $this->db->get('tarif_kode_pos')->result_array();
        $lokal = array();
        $destination_code = array();
        $tariff = array();

        $reg = '';
        $reg_asuransi = '';

        foreach ($aktif_service as $as => $aktif) {
            if($aktif == 'REG_ASURANSI'){
                $reg_asuransi = 'REG_ASURANSI';
            }
            else if($aktif == 'REG'){
                $reg = 'REG';
            }
        }
        

        if ($total_berat != 0) { // jika berat tidak 0
            foreach ($destination as $key => $value) { // tampilkan seluruh data destinasi
                // jika kota dan kecamatan nya udah sesuai

                if($value['kode_pos'] == $datana['rate']['destination']['postal_code']){
                    $value['code_jne'] = str_replace("19", "", $value['code_jne']);
                    if($value['code_jne'] == 'REG'){
                        if($reg == 'REG'){
                            $text_asuransi = 'Tanpa Asuransi';
                            $service_name = 'REG';
                            $service_code = 'REG19';
                        }
                    }
                    else if($value['code_jne'] == 'CTC'){
                        $text_asuransi = 'Tanpa Asuransi';
                        $service_name = 'REG';
                        $service_code = 'REG19';
                    }

                    $value['tarif_jne'] = str_replace(",", "", $value['tarif_jne']);
                    $total_price = $value['tarif_jne'] * $total_berat - $subsidi;
                    if ($subsidi > 0) {
                        $desk = $value['etd_from'].' - '.$value['etd_thru'].' hari (Weight: '.$total_berat.'Kg), Kamu mendapat potongan ongkir '.number_format($subsidi);
                    }else{
                        $desk = $value['etd_from'].' - '.$value['etd_thru'].' hari (Weight: '.$total_berat.'Kg)';
                    }

                    $total_price .= "00";

                    $tariff[] = array(
                        'service_name' => 'JNE - '.$service_name." ".$text_asuransi,
                        'service_code' => $service_code,
                        'description' => $desk,
                        'total_price' => $total_price,
                        'currency' => 'IDR'
                    );

                    if($value['code_jne'] == 'REG'){
                        if($reg_asuransi == 'REG_ASURANSI'){
                            $text_asuransi = 'Ditambah Asuransi';
                            $service_name = 'REG';
                            $service_code = 'REG_ASURANSI';
                            $persen_asuransi = floatval(2 / 1000);

                            $value['tarif_jne'] = str_replace(",", "", $value['tarif_jne']);
                            
                            $total_price = $value['tarif_jne'] * $total_berat;
                            $asuransi = $persen_asuransi * $total_price;
                            $asuransi_hasil = $asuransi + 5000;

                            $total_price = $total_price + $asuransi_hasil;
                            $desk = $value['etd_from'].' - '.$value['etd_thru'].' hari (Weight: '.$total_berat.'Kg)';

                            $total_price .= "00";

                            $tariff[] = array(
                                'service_name' => 'JNE - '.$service_name." ".$text_asuransi,
                                'service_code' => $service_code,
                                'description' => $desk,
                                'total_price' => $total_price,
                                'currency' => 'IDR'
                            );
                        }
                    }

                    break;
                }else{
                    continue;
                }

            }

            // ubah data tarif ke json sesuaikan dengat format yg diharuskan sama shopify
            $show_tarif = trim(json_encode($tariff), '[]');
            $data_ = '{
                "rates":[
                    '.$show_tarif.'
                ]
            }';
            
            echo $data_;
        }else{
            echo 'Weight NULL';
        }
    }

    public function testing_ongkir(){

        $tes = '<DataTable xmlns="http://schemas.datacontract.org/2004/07/System.Data"><xs:schema id="NewDataSet" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns="" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata"><xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:MainDataTable="PACKAGE_OUTPUT" msdata:UseCurrentLocale="true"><xs:complexType><xs:choice minOccurs="0" maxOccurs="unbounded"><xs:element name="PACKAGE_OUTPUT"><xs:complexType><xs:sequence><xs:element name="ORDER_NO" type="xs:string" minOccurs="0"/><xs:element name="PACKAGE_ID" type="xs:string" minOccurs="0"/><xs:element name="PACKAGE_DATE" type="xs:string" minOccurs="0"/><xs:element name="ERROR_NUMBER" type="xs:string" minOccurs="0"/><xs:element name="ERROR_MESSAGE" type="xs:string" minOccurs="0"/></xs:sequence></xs:complexType></xs:element></xs:choice></xs:complexType></xs:element></xs:schema><diffgr:diffgram xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata"><NewDataSet xmlns=""><PACKAGE_OUTPUT diffgr:id="PACKAGE_OUTPUT1" msdata:rowOrder="0"><ORDER_NO/><PACKAGE_ID/><PACKAGE_DATE>2020-11-12</PACKAGE_DATE><ERROR_NUMBER>eLexys Err : 009!!!</ERROR_NUMBER><ERROR_MESSAGE>TrackingNo : 98-20-4858465 - Already used tracking no. in eLexys system!!!</ERROR_MESSAGE></PACKAGE_OUTPUT></NewDataSet></diffgr:diffgram></DataTable>';

        $xmlna = new SimpleXMLElement($tes);
        $xmlna->registerXPathNamespace('d', 'urn:schemas-microsoft-com:xml-diffgram-v1');
        $result = $xmlna->xpath("//NewDataSet");
        $aa = array_key_exists('ERROR_NUMBER', $result);
        var_dump(isset($result[0]->PACKAGE_OUTPUT->ERROR_NUMBER));
                die();
        //var_dump("'".$xmlna."'");
        
        $jsonString = json_encode($data);

        $jsonArray = json_decode($jsonString, true);
        var_dump($jsonArray);
        die();

        $id_merchant = '42391208086';
        // cari aktif service
        $merchant_row = $this->Data_master_m->merchant_byid($id_merchant);
        $list_service = explode(',', $merchant_row->servicena);
        $aktif_service = [];
        foreach ($list_service as $key => $value) {
            if ($value != '') {
                $aktif_service[] = strtoupper($value); 
            }
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $datana = file_get_contents('php://input');
        $this->db->insert('tes', array(
         'datana' => $datana,
         'id_variant' => 'tess',
         'create_at' => date('Y-m-d H:i:s')
        ));
        $datana = '
        {"rate":
            {
            "origin":{
                "country":"ID",
                "postal_code":"40113",
                "province":"JB",
                "city":"Bandung",
                "name":null,
                "address1":"15 Jalan Lombok",
                "address2":"",
                "address3":null,
                "phone":"",
                "fax":null,
                "email":null,
                "address_type":null,
                "company_name":"ngetes-narrative"
            },
            "destination":{
                "country":"ID",
                "postal_code":"40175",
                "province":"JB",
                "city":"Depok",
                "name":"Aditya Sholahudin",
                "address1":"jakarta",
                "address2":"Limo",
                "address3":null,
                "phone":"0812-8827-866",
                "fax":null,
                "email":"aditya@bolehdicoba.com",
                "address_type":null,
                "company_name":null
            },
            "items":[{
                "name":"Product 1 (A) - L \/ Red",
                "sku":"","quantity":2,
                "grams":400,
                "price":20000000,
                "vendor":"ngetes-narrative",
                "requires_shipping":true,
                "taxable":true,
                "fulfillment_service":"manual",
                "properties":{},
                "product_id":4603620819032,
                "variant_id":32807995015256
            },
            {
                "name":"Product 1 (A) - L \/ Red",
                "sku":"","quantity":2,
                "grams":400,
                "price":25000000,
                "vendor":"ngetes-narrative",
                "requires_shipping":true,
                "taxable":true,
                "fulfillment_service":"manual",
                "properties":{},
                "product_id":4603620819032,
                "variant_id":32807995015256
            }],
            "currency":"IDR","locale":"en"}}';

        // echo $datana;
        
        $datana = json_decode($datana, TRUE);
        if ($datana['rate']['destination']['city'] == 'jaksel') {
            $city = 'jakarta selatan';
        }elseif ($datana['rate']['destination']['city'] == 'jakbar') {
            $city = 'jakarta barat';
        }elseif ($datana['rate']['destination']['city'] == 'jaktim') {
            $city = 'jakarta timur';
        }elseif ($datana['rate']['destination']['city'] == 'jakpus') {
            $city = 'jakarta pusat';
        }elseif ($datana['rate']['destination']['city'] == 'tangsel') {
            $city = 'tangerang selatan';
        }else{
            $city = $datana['rate']['destination']['city'];
        }

        // cari data berat produk
        $total_berat = 0;
        $total_price_produk = 0;
        foreach ($datana['rate']['items'] as $key => $value) {
            $jml_berat = $value['grams'] * $value['quantity'];
            $total_berat += ($jml_berat / 1000);
            $total_price_produk += $value['price'];
        }

        $total_price_produk = substr($total_price_produk, 0, -2);

        if ($merchant_row->subsidi_ongkir > 0) {
            if ($total_price_produk > $merchant_row->minimum_order) {
                $subsidi = $merchant_row->subsidi_ongkir;
            }else{
                $subsidi = 0;
            }
        }else{
            $subsidi = 0;
        }

        // tentukan berat produk
        if ($total_berat < 0) {
            $total_berat = 0;
        }elseif ($total_berat < 1) {
            $total_berat = 1;
        }else{
            $total_berat = round($total_berat,0);
        }


        $destination = $this->db->get('tarif')->result_array();
        $lokal = array();
        $destination_code = array();
        $tariff = array();

        $reg_asuransi = '';
        $yes_asuransi = '';
        $sps_asuransi = '';
        $with_asuransi = '';


        $kota = strtolower($city);
        $jakarta = 'jakarta';
        $pos = strpos($kota, $jakarta);

        if ($total_berat != 0) { // jika berat tidak 0
            
            foreach ($destination as $key => $value) { // tampilkan seluruh data destinasi
                // jika kota dan kecamatan nya udah sesuai

                // $kalimat = $city;
                // $cari = $value['city'];
                // $posisi = strpos(strtolower($kalimat),strtolower($cari));

                // if($posisi !== null){
                //     $city = $value['city'];
                // }

                if (strpos(strtolower($value['city']), strtolower($city)) !== false && strpos(strtolower($value['subdistrict']), strtolower($datana['rate']['destination']['address2'])) !== false ) {

                    echo $value['city']."=>".$value['subdistrict'];
                    // tampilkan data tarif
                    $tarif = $this->shopify->jne_get($value['destination_code'], 1);
                    $tarifna = json_decode($tarif, true);
                    // jika tarif ditemukan
                    if ($tarifna['price'] != null) {
                        // cari tarif berdasarkan service yang aktif
                        foreach ($tarifna['price'] as $x => $y) {
                            foreach ($aktif_service as $as => $aktif) {

                                // $baru = str_replace("CTC","",$y['service_display']);
                                // echo $y['service_display']."=>".$baru." ";

                                if($aktif == 'REG_ASURANSI'){
                                    $reg_asuransi = 'REG_ASURANSI';
                                }
                                else if($aktif == 'YES_ASURANSI'){
                                    $yes_asuransi = 'YES_ASURANSI';
                                }
                                else if($aktif == 'SPS_ASURANSI'){
                                    $sps_asuransi = 'SPS_ASURANSI';
                                }



                                if(str_replace("CTC","",$y['service_display']) != null){
                                    $data_sd = str_replace("CTC","",$y['service_display']);


                                    if (strpos($aktif, $data_sd) !== false) {
                                        // echo $aktif."=>".str_replace("CTC","",$y['service_display'])."";
                                        // echo $aktif."=>";
                                        $persen_asuransi = floatval(2 / 1000);
                                        
                                        if ($y['service_display'] == 'REG') {
                                            if($aktif == 'REG_ASURANSI'){
                                                $with_asuransi = 'With Asuransi REG';
                                                $total_price = $y['price'] * $total_berat;

                                                $asuransi = $persen_asuransi * $total_price;
                                                $asuransi_hasil = $asuransi + 5000;

                                                $total_price = $total_price + $asuransi_hasil;
                                            }
                                            else{
                                                $with_asuransi = '';
                                                $total_price = $y['price'] * $total_berat - $subsidi;
                                            }
                                            
                                        }else{
                                            if ($y['service_display'] == 'YES') {
                                                if($aktif == 'YES_ASURANSI'){
                                                    $with_asuransi = 'With Asuransi YES';
                                                    $total_price = $y['price'] * $total_berat;

                                                    $asuransi = $persen_asuransi * $total_price;
                                                    $asuransi_hasil = $asuransi + 5000;

                                                    $total_price = $total_price + $asuransi_hasil;
                                                }
                                                else{
                                                    $with_asuransi = '';
                                                    $total_price = $y['price'] * $total_berat - $subsidi;
                                                }
                                            }
                                            else if ($y['service_display'] == 'SPS') {

                                                if($aktif == 'SPS_ASURANSI'){
                                                    $with_asuransi = 'With Asuransi SPS';
                                                    $total_price = $y['price'] * $total_berat;

                                                    $asuransi = $persen_asuransi * $total_price;
                                                    $asuransi_hasil = $asuransi + 5000;

                                                    $total_price = $total_price + $asuransi_hasil;
                                                }
                                                else{
                                                    $with_asuransi = '';
                                                    $total_price = $y['price'] * $total_berat - $subsidi;
                                                }
                                            }
                                            else{
                                                $total_price = $y['price'] * $total_berat;
                                            }
                                        }
                                        $total_price .= "00";
                                        // }
                                        // echo $y['price']."=>".$y['service_code']." ";

                                        $tariff[] = array(
                                            'service_name' => 'JNE - '.$y['service_display']." ".$with_asuransi,
                                            'service_code' => $y['service_code'],
                                            'description' => $y['etd_from'].' - '.$y['etd_thru'].' hari (Weight: '.$total_berat.'Kg)',
                                            'total_price' => $total_price,
                                            'currency' => 'IDR'
                                        );
                                    }
                                }
                            }
                        }
                    }
                    // jika tarif ditemukan hentikan looping
                    break;
                }else{
                    // jika tarif tidak ditemukan lanjutkan looping
                    continue;
                }

            }

            if ($pos !== false) {
                $tariff[] = array(
                    'service_name' => 'Same day Delivery Jakarta (Gojek)',
                    'service_code' => '',
                    'description' => '',
                    'total_price' => '3000000',
                    'currency' => 'IDR'
                );
            }
            // ubah data tarif ke json sesuaikan dengat format yg diharuskan sama shopify
            $show_tarif = trim(json_encode($tariff), '[]');
            $data_ = '{
                "rates":[
                    '.$show_tarif.'
                ]
            }';
            
            echo $data_;
        }else{
            echo 'Weight NULL';
        }

        

        // $im_destination =implode(',', $destination_code);
        //var_dump($this->Data_master_m->get_rate($im_destination));
    }


    function show_ongkir(){
    	$data['ongkir'] = $this->Data_master_m->get_all_ongkir();
    	
        $this->template->load('template_config','front/list_ongkir', $data);
    }

    public function insert_tes2(){
    	$id_merchant = '6408405080';
        $merchant_row = $this->Data_master_m->merchant_byid($id_merchant);
        $list_service = explode(',', $merchant_row->servicena);
        $aktif_service = [];
        foreach ($list_service as $key => $value) {
        	if ($value != '') {
        		$aktif_service[] = "'".$value."'";
        	}
        }

        $aktif_service = implode(',', $aktif_service);
        
    	header('Access-Control-Allow-Origin: *');
    	header('Content-Type: application/json');
        $datana = file_get_contents('php://input');
        //$datana = '{"rate":{"origin":{"country":"ID","postal_code":"40113","province":"JB","city":"Bandung","name":null,"address1":"15 Jalan Lombok","address2":"","address3":null,"phone":"","fax":null,"email":null,"address_type":null,"company_name":"ngetes-narrative"},"destination":{"country":"ID","postal_code":"34890","province":"JK","city":"jakarta","name":"iunui iuniu","address1":"iuniuniu","address2":"mampangprapatan","address3":null,"phone":"0877-8889-990","fax":null,"email":null,"address_type":null,"company_name":null},"items":[{"name":"Sample Tshirt - S","sku":"","quantity":1,"grams":300,"price":15000000,"vendor":"ngetes-narrative","requires_shipping":true,"taxable":false,"fulfillment_service":"manual","properties":{},"product_id":4602723762264,"variant_id":32801957806168}],"currency":"IDR","locale":"en"}}';
        $this->db->insert('tes', array(
        	'datana' => $datana,
        	'id_variant' => 'tess',
        	'create_at' => date('Y-m-d H:i:s')
        ));
        $datana = json_decode($datana, TRUE);
        if ($datana['rate']['destination']['city'] == 'jaksel') {
        	$city = 'jakarta selatan';
        }elseif ($datana['rate']['destination']['city'] == 'jakbar') {
        	$city = 'jakarta barat';
        }elseif ($datana['rate']['destination']['city'] == 'jaktim') {
        	$city = 'jakarta timur';
        }elseif ($datana['rate']['destination']['city'] == 'jakpus') {
        	$city = 'jakarta pusat';
        }elseif ($datana['rate']['destination']['city'] == 'tangsel') {
        	$city = 'tangerang selatan';
        }else{
        	$city = $datana['rate']['destination']['city'];
        }
        $ongkir_dasar = $this->Data_master_m->get_ongkir_dasar($datana['rate']['destination']['address2'],$city,$aktif_service);
        
        $list_ongkir = array();
        foreach ($ongkir_dasar as $key => $value) {
        	$value['tarif'] .= "00";
        	$list_ongkir[] = array(
        		'service_name' => 'SICEPAT - '.$value['service'],
        		'service_code' => $value['kode_service'],
        		'description' => $value['etd'],
        		'total_price' => $value['tarif'],
        		'currency' => 'IDR'
        	);
        }
        $yourJson = trim(json_encode($list_ongkir), '[]');
        
		$data = '{
			"rates":[
				'.$yourJson.'
			]
		}';
		echo $data;

		return $data;
    }
    function create_ongkir(){
    	//$tariff = $this->shopify->sicepat_get('tariff?origin=BDO&destination=BDO10000&weight=1');
    	$destination = $this->shopify->sicepat_get('destination');
    	$destination = json_decode($destination, TRUE);
    	$lokal = array();

    	foreach ($destination['sicepat']['results'] as $key => $value) {
    		// if ($value['province'] == 'NUSA TENGGARA BARAT (NTB)') {
    			$data = $this->shopify->sicepat_get('tariff?origin=CGK&destination='.$value['destination_code'].'&weight=1');
    			$data = json_decode($data, TRUE);
    			if ($data['sicepat']['status']['code'] == 400) {
    				if ($this->Data_master_m->destination_row($value['destination_code']) == NULL) {
    					$input_data = array(
    						'origin' => 'CGK',
    						'destination_code' => $value['destination_code'],
    						'city' => $value['city'],
    						'subdistrict' => $value['subdistrict'],
    					);

    					$this->db->insert('tarif' , $input_data);
    				}
    				$lokal[] = array(
    					'status_code' => $data['sicepat']['status']['code'],
    					'destination_code' => $value['destination_code'],  
    					'city' => $value['city'],  
    					'subdistrict' => $value['subdistrict'],  
    				);
    			}else{
    				if ($this->Data_master_m->destination_row($value['destination_code']) == NULL) {
    					$input_data = array(
    						'origin' => 'CGK',
    						'destination_code' => $value['destination_code'],
    						'city' => $value['city'],
    						'subdistrict' => $value['subdistrict'],
    					);

    					$this->db->insert('tarif' , $input_data);

    					$last_id = $this->db->insert_id();
    					foreach ($data['sicepat']['results'] as $x => $y) {
    						$input_service = array(
	    						'id_tarif' => $last_id,
	    						'service' =>  $y['service'],
	    						'description' =>  $y['description'],
	    						'tarif' =>  $y['tariff'],
	    						'etd' =>  $y['etd']
	    					);

	    					$this->db->insert('tarif_service', $input_service);
    					}
    					
    				}
    				$lokal[] = $data['sicepat']['results'];
    			}
    		// }
    	}

    	var_dump($lokal);
    }

    public function tess(){
    	header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
    	extract($_POST);
	    //$merchant_row = $this->Data_master_m->merchant_row($shop);
    	$data = $_POST;
    	    		
	    if ($data['no_order'] == NULL) {
    		$data = array(
    			'kode' => 1,
    			'messages' => "No order can't be blank"
    		);

    		echo json_encode($data) ;
    	}elseif ($data['email_order'] == NULL) {
    		$data = array(
    			'kode' => 2,
    			'messages' => "Email can't be blank"
    		);

    		echo json_encode($data) ;
    	}elseif ($data['tgl_tf'] == NULL) {
    		$data = array(
    			'kode' => 3,
    			'messages' => "Transfer date can't be blank"
    		);

    		echo json_encode($data) ;
    	}elseif ($_FILES['bukti_tf']['name'] == NULL) {
    		$data = array(
    			'kode' => 4,
    			'messages' => "Image proof can't be blank"
    		);

    		echo json_encode($data) ;
    	}else{
    		$orders = $this->shopify->api_get($data['shop'], "orders.json?status=any&name=".$data['no_order']."", $data['token_store']);
    		$orders = json_decode($orders, true);

    		if (sizeof($orders['orders']) < 1) {
    			$data = array(
	    			'kode' => 5,
	    			'messages' => "No order not found."
	    		);

	    		echo json_encode($data) ;
    		}else{
	    		foreach ($orders['orders'] as $key => $value) {
	    			$id_merchant = $value['order_status_url'];
	    			$id_merchant = preg_split("#/#", $id_merchant); 
	    			if ($value['email'] != $data['email_order']) {
	    				$data = array(
			    			'kode' => 6,
			    			'messages' => "No order and email not match."
			    		);

			    		echo json_encode($data) ;
	    			}elseif ($value['financial_status'] == 'paid') {
		        		$data = array(
			    			'kode' => 7,
			    			'messages' => "Payment accepted"
			    		);

			    		echo json_encode($data) ;
		        	}elseif ($value['financial_status'] == 'void') {
		        		$data = array(
			    			'kode' => 6,
			    			'messages' => "Order Cancelled, contact the administrator."
			    		);

			    		echo json_encode($data) ;
		        	}else{
	        			$upload1 = $_FILES['bukti_tf']['name'];
					    $nmfile1 = $data['no_order']."_".time()."_".$upload1;

					    if($upload1 !== ""){
					        $config['upload_path']          = './image-proof/';
					        $config['allowed_types']        = 'pdf|jpg|jpeg|png';
					        $config['max_size']             = 2000;
					        $config['file_name']            = $nmfile1;
					           
					        $this->load->library('upload', $config);
	            			$this->upload->initialize($config);
					        $this->upload->do_upload('bukti_tf');
					        if ($this->upload->display_errors() != NULL) {
					            $data = array(
					    			'kode' => 7,
					    			'messages' => $this->upload->display_errors()
					    		);

					    		echo json_encode($data) ;
					        	die();
					        }               
					        $data1 = $this->upload->data();
					        
					    	$bukti_tfna = $data1['file_name'];
					    }else{
					    	$bukti_tfna = NULL;
					    }

					    if ($bukti_tfna != NULL) {
					    	$edit_orders = '
					    		{
									"order": {
								    	"id": '.$value['id'].',
								    	"note_attributes": [
									     	{
									        	"name": "Image transfer proof",
									        	"value": "'.base_url().'image-proof/'.$bukti_tfna.'"
									      	}
									    ],
								    	"tags": "paid-confirm"
								  	}
								}
					    	';

					    	$edit_order = $this->shopify->api_put($data['shop'], "orders/".$value['id'].".json", $data['token_store'], $edit_orders);

					    	$data_tf = array(
					    		'id' => $this->Data_master_m->create_id_proof(),
					    		'id_merchant' => $id_merchant[3],
					    		'no_order' => $data['no_order'],
					    		'email' => $data['email_order'],
					    		'tgl_transfer' => date('Y-m-d', strtotime($data['tgl_tf'])),
					    		'bayar_ke' => $bayarke,
					    		'bukti_tf' => $_FILES['bukti_tf']['name'],
					    		// 'catatan' => $catatan,
					    		'create_at' => date('Y-m-d H:i:s'),
					    	);

					    	$this->db->insert('paid_confirm',$data_tf);
					    }


	        			$data = array(
			    			'kode' => 'ok',
			    			'messages' => "Confirm Payment accepted."
			    		);

			    		echo '<span class="badge badge-success">Confirm Payment accepted.</span>' ;
		        	} 
		        }
		    }
    	}
    	
    	// var_dump($_FILES['bukti_tf']['name']);
    }

    public function index(){
    	$this->template->load('template_portee','front/index');
    }

    public function bukti_tf(){
    	extract($_POST);

    	if ($no_order == NULL) {
    		$data = array(
    			'kode' => 1,
    			'messages' => "No order can't be blank"
    		);

    		echo json_encode($data) ;
    	}elseif ($email == NULL) {
    		$data = array(
    			'kode' => 2,
    			'messages' => "Email can't be blank"
    		);

    		echo json_encode($data) ;
    	}elseif ($tgl_tf == NULL) {
    		$data = array(
    			'kode' => 3,
    			'messages' => "Transfer date can't be blank"
    		);

    		echo json_encode($data) ;
    	}elseif ($bayarke == NULL) {
    		$data = array(
    			'kode' => 3,
    			'messages' => "Transfer date can't be blank"
    		);

    		echo json_encode($data) ;
    	}else{
    		$shop = 'porteegoods.myshopify.com';
	    	$id_merchant = '33062027397';
	    	$merchant_row = $this->Data_master_m->merchant_row($shop);
	        $this->load->library('shopify');
	        $orders = $this->shopify->shopify_call($merchant_row->token_store, $shop, "/admin/api/2020-01/orders.json?name=".$no_order."&status=any", array(), 'GET');
	        $orders = json_decode($orders['response'], true);
	        
	        if (sizeof($orders['orders']) == 0) {
	        	$data = array(
	    			'kode' => 4,
	    			'messages' => "No order not found"
	    		);

	    		echo json_encode($data) ;
	        }else{
		        foreach ($orders['orders'] as $key => $value) {
		        	if ($value['financial_status'] == 'paid') {
		        		$data = array(
			    			'kode' => 5,
			    			'messages' => "Payment accepted"
			    		);

			    		echo json_encode($data) ;
		        	}elseif ($value['financial_status'] == 'void') {
		        		$data = array(
			    			'kode' => 6,
			    			'messages' => "Order Cancelled, contact the administrator."
			    		);

			    		echo json_encode($data) ;
		        	}else{
		        		if ($value['email'] == $email) {
		        			$upload1 = $_FILES['bukti_tf']['name'];
						    $nmfile1 = $no_order."_".time()."_".$upload1;

						    if($upload1 !== ""){
						        $config['upload_path']          = './image-proof/';
						        $config['allowed_types']        = 'pdf|jpg|jpeg|png';
						        $config['max_size']             = 2000;
						        $config['file_name']            = $nmfile1;
						           
						        $this->load->library('upload', $config);
	                			$this->upload->initialize($config);
						        $this->upload->do_upload('bukti_tf');
						        if ($this->upload->display_errors() != NULL) {
						            $data = array(
						    			'kode' => 7,
						    			'messages' => $this->upload->display_errors()
						    		);

						    		echo json_encode($data) ;
						        	die();
						        }               
						        $data1 = $this->upload->data();
						        
						    	$bukti_tfna = $data1['file_name'];
						    }else{
						    	$bukti_tfna = NULL;
						    }

						    if ($bukti_tfna != NULL) {
						    	$edit_orders = '
						    		{
										"order": {
									    	"id": '.$value['id'].',
									    	"note_attributes": [
										     	{
										        	"name": "Image transfer proof",
										        	"value": "'.base_url().'image-proof/'.$bukti_tfna.'"
										      	}
										    ],
									    	"tags": "paid-confirm"
									  	}
									}
						    	';

						    	$edit_order = $this->shopify->api_put($shop, "orders/".$value['id'].".json", $merchant_row->token_store, $edit_orders);

						    	$data_tf = array(
						    		'id' => $this->Data_master_m->create_id_proof(),
						    		'id_merchant' => $id_merchant,
						    		'no_order' => $no_order,
						    		'email' => $email,
						    		'tgl_transfer' => date('Y-m-d', strtotime($tgl_tf)),
						    		'bayar_ke' => $bayarke,
						    		'bukti_tf' => $bukti_tfna,
						    		'catatan' => $catatan,
						    		'create_at' => date('Y-m-d H:i:s'),
						    	);

						    	$this->db->insert('paid_confirm',$data_tf);
						    }


		        			$data = array(
				    			'kode' => 'ok',
				    			'messages' => "Confirm Payment accepted."
				    		);

				    		echo json_encode($data) ;
		        		}else{
		        			$data = array(
				    			'kode' => 8,
				    			'messages' => "No order and email not match."
				    		);

				    		echo json_encode($data) ;
		        		}
		        	}
		        }
		    }

    	}
    }

    public function faq(){
    	$this->template->load('template_front','front/faq');
    }

    public function privacypolicy(){
    	$this->template->load('template_front','front/privacy');
    }

    public function addstore(){
    	$this->template->load('template_front','front/addstore');
    }

    public function install(){
    	$api_key = $this->config->item('shopify_api_key');
	    $scopes = $this->config->item('scopes');
	   	$redirect_uri = $this->config->item('redirect_url');
	   	$redirect_scope = $this->config->item('generate_scope');
	   	$redirect_install_lagi = $this->config->item('install_lagi');

    	if ( !empty($_POST) ) {
    		extract($_POST);
	    	
	    	// var_dump(urlencode($redirect_uri));
	    	// die();
	    	// Build install/approval URL to redirect to
			$install_url = "https://" . $urlna . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

			// Redirect
			header("Location: " . $install_url);
    	}else{
    		$params = $_GET; // Retrieve all request parameters
	        $hmac = $_GET['hmac']; // Retrieve HMAC request parameter
	        $urlna = $_GET['shop']; 
	        
        	$merchant_row = $this->Data_master_m->merchant_row($urlna);
        	
        	if ($merchant_row == NULL) {
        		$install_url = "https://" . $urlna . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

				header("Location: " . $install_url);
        	}else{
        		$this->load->library('shopify');

        		$scopena = $this->shopify->shopify_call($merchant_row->token_store, $merchant_row->url_shopify, "/admin/oauth/access_scopes.json", array(), 'GET');
        		$scopena = json_decode($scopena['response'], TRUE);
        		
        		// if ($scopena['errors'] == NULL OR $scopena['errors'] == '' ) {
        			if (sizeof($scopena['access_scopes']) == 6) {
	        			// echo 'tes';
	        			// die();
	        			if ($merchant_row->id_shipping == 0) {
	        				redirect('config/app_config_first/'.$merchant_row->id_merchant);
	        			}else{
	        				redirect('config/setting_product/'.$merchant_row->id_merchant);
	               		}
	        		}else{
	        			
	        			$re_install = 'https://'.$merchant_row->url_shopify.'/admin/oauth/authorize?client_id='.$api_key.'&scope='.$scopes.'&redirect_uri='.urlencode($redirect_scope);
	        			
	        			if (getallheaders()['sec-fetch-dest'] == 'iframe'){
	        				echo '<p style="text-align: center;">Please update again this app to add new scopes. </p><br />';
	        				echo '<a href="'.$re_install.'" style="text-align: center; background: #177bf7; color: #fff; max-width: 120px; display: block; text-decoration: none; margin: 15px auto; padding: 15px;" target="_top">Update App</a>';
	        			}else{
							header("Location: " . $re_install);
	        			}
	        		}
       //  		}else{
	   			// 	$install_lagi = 'https://'.$merchant_row->url_shopify.'/admin/oauth/authorize?client_id='.$api_key.'&scope='.$scopes.'&redirect_uri='.urlencode($redirect_install_lagi);

       //  			if (getallheaders()['sec-fetch-dest'] == 'iframe'){
	      //   			echo '<p style="text-align: center;">Invalid token, please update authentication.</p> <br />';
	      //   			echo '<a href="'.$install_lagi.'" style="text-align: center; background: #177bf7; color: #fff; max-width: 120px; display: block; text-decoration: none; padding: 15px; margin: 15px auto;" target="_top">Update Here</a>';
	      //   		}else{
							// header("Location: " . $re_install);
	      //   		}
       //  		}	
        	}
    	}
    }

    public function install_lagi(){

    	$api_key = $this->config->item('shopify_api_key');
		$shared_secret = $this->config->item('shopify_secret');
	    
		$headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        parse_str($_SERVER['QUERY_STRING'], $outputArray);
		
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
	        
	        $merchant_row = $this->Data_master_m->merchant_row($params['shop']);
			// var_dump($merchant_row->id);
   //  		die();
			$this->db->where('id', $merchant_row->id);
			$this->db->update('merchant_data', array(
				'token_store' => $access_token
			));

			redirect('https://'.$params['shop'].'/admin/apps');

		} else {
			// Someone is trying to be shady!
			die('This request is NOT from Shopify!');
		}
    }

    public function generate_scope(){
    	
    	$api_key = $this->config->item('shopify_api_key');
		$shared_secret = $this->config->item('shopify_secret');
	    
		$headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        parse_str($_SERVER['QUERY_STRING'], $outputArray);
		
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
	        
			redirect('https://'.$params['shop'].'/admin/apps');

		} else {
			// Someone is trying to be shady!
			die('This request is NOT from Shopify!');
		}
    }

    public function generate_token(){
    	$api_key = $this->config->item('shopify_api_key');
		$shared_secret = $this->config->item('shopify_secret');
	    
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
	        $this->save_merchant($access_token,$params['shop'],$hmac);

			redirect('https://'.$params['shop'].'/admin');

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
			'email_notification' => $shop['shop']['email'],
			'phone_merchant' => $shop['shop']['phone'],
		    'nama_merchant' => $shop['shop']['name'],
		    'ac_active' => 0,
		    'waktu_ac' => 48,
		    'type_ac' => 'hours',
		    'servicena' => 'reg,yes,sps',
		    'titlena' => 'Paid Confirm Form',
		    'contentna' => 'Use this form for payment via Bank Deposit',
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
                "address": "https://bdd.delamibrands.com/shipping/webhooks/app_uninstall",
                "format": "json"
            }
        }';


        $scriptTag = $this->shopify->api_post($url_shop, "webhooks.json", $access_token, $webhookna);


		//redirect('/config/setting_product/'.$shop['shop']['id']);
    }

    public function request_install(){
    	extract($_POST);

    	var_dump($_POST);
    }

    function help(){

    	$this->template->load('template_front','front/help');

    }
}