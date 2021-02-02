<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

    function tes(){
        $shop = $this->db->get_where('merchant_data', array('url_shopify' => 'color-box-indo.myshopify.com'))->row();
        $order = $this->shopify->request($shop->url_shopify,'4574d926f6560389ad278980ac3fcdcd','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','orders.json');
        var_dump($order);
    }

    function view_report(){
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

        $shop = $this->db->get_where('merchant_data', array('url_shopify' => $_GET["shop"]))->row();

        // echo $shop->token_store;

        $id = implode(',', $_GET['ids']);

        $order = $this->shopify->api_get($shop->url_shopify, 'orders.json?status=any&ids='.$id, $shop->token_store);
        $order = json_decode($order, TRUE);

        // var_dump($order['orders'][0]['tags']);
        // die();

        echo "<div style='display : none;'>". json_encode($order)."</div>";

        $data_order = array();
        $datana = array();
        $variantna = '';

        $card_type = '';
        $card_number = '';
        $idna = '';
        $tag_price = 0;
        $total_discount = 0;
        $discount = 0;
        $discount_shipping = 0;
        $reduction = 0;
        $net = 0;

        $no = 1;
        $nona = 1;

        $data_valid = array();

        if(!empty($order['orders'])){
            foreach ($order['orders'] as $key => $value) {
                foreach ($value['line_items'] as $d => $l) {
                    if (!in_array($l['product_id'], array_column($data_valid, 'idna'))) {
                        $data_valid[] = array(
                            'idna' => $l['product_id'],
                            'qty' => $l['quantity'],
                            'orderna' => $value['name']
                        ); 
                    }
                }
            }
        }

        foreach ($data_valid as $key => $value) {
            // echo $no++."=>".$value['idna']."=>".$value['qty']."=>".$value['orderna']."<br>";
            $idna .= $value['idna'].",";
        }

        $produk = $this->shopify->shopify_call($shop->token_store, $shop->url_shopify, "/admin/api/2020-07/products.json?limit=250&ids=".$idna, array(), 'GET', $headerna);
        $produk = $produk['response'];
        $produk = json_decode($produk, JSON_PRETTY_PRINT);

        // foreach ($produk['products'] as $p => $r) {
        //  echo $nona++."=>".$r['id']."<br>";
        // }
        $message_trans = '';
        $x_reference = '';


        if(!empty($order['orders'])){
            foreach ($order['orders'] as $key => $value) {

                if($value['shipping_lines'][0]['code'] == 'REG_ASURANSI'){
                    $insurance = 'Y';
                }
                else{
                    $insurance = 'N';
                }
                // echo $value['billing_address']['name'];
                $trans = $this->shopify->shopify_call($shop->token_store, $shop->url_shopify, "/admin/api/2020-07/orders/".$value['id']."/transactions.json", array(), 'GET', $headerna);
                $trans = $trans['response'];
                $trans = json_decode($trans, JSON_PRETTY_PRINT);

                foreach ($trans['transactions'] as $t => $r) {
                    if ($r['status'] == 'success') {
                        // echo $r['message']." => ".$value['order_number']."<br>";
                        $message_trans = $r['message'];
                        $x_reference = $r['receipt']['x_reference'];
                    }
                }

                if($value['shipping_lines'][0]['title'] == 'Lion Parcel - Cash on Delivery (COD)'){
                    if($value['fulfillments'] != null){
                        $x_reference = $value['fulfillments'][0]['tracking_number'];
                    }
                }

                // foreach ($value['payment_gateway_names'] as $pg => $pgn) {
                //     if($pgn == 'xendit'){
                        
                //     }
                //     else{
                //         $payment = "T";
                //     }
                // }

                if($message_trans == 'Payment Method : CREDIT_CARD'){
                    $payment = "B";
                }
                else{
                    $payment = "T";
                }

                $free_shipping = false;

                foreach ($value['shipping_lines'] as $s => $h) {
                    $cost = $h['price'];
                    $logistik = $h['title'];
                    if($h['discount_allocations'] != null){
                        // echo "<pre>";
                        // var_dump($h['discount_allocations']);
                        // echo "</pre>";
                        foreach ($h['discount_allocations'] as $sd => $da) {
                            $cost = $cost - $da['amount'];
                            $free_shipping = true;
                        } 
                    }
                    else{
                        $discount_shipping = 0;
                    }
                }

                // $net = array();

                foreach ($value['line_items'] as $d => $l) {
                    if($l['discount_allocations'] != null){
                       foreach ($l['discount_allocations'] as $di => $al) {
                            $discount = $al['amount'];
                            // echo $l['price']." ".$al['amount']."=>";
                            // $net = $l['price'] - $discount;
                            $net = $l['price'];

                            // echo $l['price']." - ".$discount." = ".$net."<br>";
                        } 
                    }
                    else{
                        $discount = 0;
                        $net = $l['price'];
                    }

                    foreach ($produk['products'] as $p => $r) {
                        foreach ($r['variants'] as $v => $s) {
                            if($l['product_id'] == $s['product_id']){
                                // echo $s[''];
                                if($s['compare_at_price'] != null){
                                    if($s['compare_at_price'] > $s['price']){
                                        $tag_price = $s['compare_at_price'];
                                        $reduction = $s['compare_at_price'] - $s['price'];
                                    }
                                    else{
                                        $reduction = 0;
                                        $tag_price = $l['price'];
                                    }
                                }
                                else{
                                    $reduction = 0;
                                    $tag_price = $l['price'];
                                }

                                // echo $l['title']." => product tag price (".$tag_price.")"." => potongan (".$reduction.")"."<br>";

                            }
                            break;
                        }
                    }
                    
                    $created_result = substr($value['created_at'], 0, strpos($value['created_at'], "T"));
                    $newDate = date("d-m-y", strtotime($created_result));
                    $created = str_replace('-', '.', $newDate);

                    if($free_shipping == true){
                        $vch = 0;
                    }
                    else{
                        $vch = str_replace('.00', '', $value['total_discounts']);
                    }

                    // utf8_encode(money_format('%.0n', $discount))
                    // utf8_encode(money_format('%.0n', $net))


                    $data_order[] = array(
                        'order_number' => utf8_encode(money_format('%.0n', $value['order_number'])),
                        'created_at' => $created,
                        'name' => $value['billing_address']['name'],
                        'sku' => (string)$l['sku'],
                        'product_name' => $l['name'],
                        'quantity' => $l['quantity'],
                        'price' => utf8_encode(money_format('%.0n', $value['total_price'])),
                        'tag_price' => utf8_encode(money_format('%.0n', $tag_price)),
                        'reduction' => utf8_encode(money_format('%.0n', $reduction)),
                        'voucher' => $vch,
                        'net' => utf8_encode(money_format('%.0n', $net)),
                        // 'address1' => $value['customer']['default_address']['address1'],
                        // 'address2' => $value['customer']['default_address']['address2'],
                        // 'province' => $value['customer']['default_address']['province'],
                        // 'zip' => $value['customer']['default_address']['zip'],
                        // 'city' => $value['customer']['default_address']['city'],
                        // 'country' => $value['customer']['default_address']['country'],
                        // 'phone' => $value['customer']['default_address']['phone'],
                        'customer_name' => $value['billing_address']['name'],
                        'receiver_name' => $value['shipping_address']['name'],
                        'receiver_address' => $value['shipping_address']['address1'].", ".$value['shipping_address']['address2'],
                        'receiver_city' => $value['shipping_address']['city'],
                        'receiver_province' => $value['shipping_address']['province'],
                        'receiver_country' => $value['shipping_address']['country'],
                        'receiver_zip' => $value['shipping_address']['zip'],
                        'receiver_phone' => $value['shipping_address']['phone'],
                        'shipping_cost' => utf8_encode(money_format('%.0n', $cost)),
                        'logistik' => $logistik,
                        'payment' => $payment,
                        'card_type' => $card_type,
                        'card_number' => $card_number,
                        'reference' => $x_reference,
                        'insurance' => $insurance
                    );
                    $idna .= $l['product_id'].",";
                }
            }
        }

        $data['ids'] = $id;
        $data['orders'] = $data_order;
        $data['shop'] = $shop;

        $this->load->view('report_view', $data);
    }

    public function export(){
        extract($_POST);
        require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

        $shop = $this->db->get_where('merchant_data', array('url_shopify' => $shop))->row();

        $id = $ids;
        $id_tag = explode(',', $id);

        $order = $this->shopify->api_get($shop->url_shopify, 'orders.json?status=any&ids='.$id, $shop->token_store);
        $order = json_decode($order, TRUE);

        $data_order = array();
        $datana = array();
        $variantna = '';

        $card_type = '';
        $card_number = '';
        $idna = '';
        $tag_price = 0;
        $total_discount = 0;
        $discount = 0;
        $discount_shipping = 0;
        $reduction = 0;
        $net = 0;

        $no = 1;
        $nona = 1;

        $data_valid = array();

        if(!empty($order['orders'])){
            foreach ($order['orders'] as $key => $value) {
                foreach ($value['line_items'] as $d => $l) {
                    if (!in_array($l['product_id'], array_column($data_valid, 'idna'))) {
                        $data_valid[] = array(
                            'idna' => $l['product_id'],
                            'qty' => $l['quantity'],
                            'orderna' => $value['name']
                        ); 
                    }
                }
            }
        }

        foreach ($data_valid as $key => $value) {
            // echo $no++."=>".$value['idna']."=>".$value['qty']."=>".$value['orderna']."<br>";
            $idna .= $value['idna'].",";
        }

        $produk = $this->shopify->shopify_call($shop->token_store, $shop->url_shopify, "/admin/api/2020-07/products.json?limit=250&ids=".$idna, array(), 'GET', $headerna);
        $produk = $produk['response'];
        $produk = json_decode($produk, JSON_PRETTY_PRINT);

        // foreach ($produk['products'] as $p => $r) {
        //  echo $nona++."=>".$r['id']."<br>";
        // }

        $message_trans = '';
        $x_reference = '';


        if(!empty($order['orders'])){
            foreach ($order['orders'] as $key => $value) {
                if($value['shipping_lines'][0]['code'] == 'REG_ASURANSI'){
                    $insurance = 'Y';
                }
                else{
                    $insurance = 'N';
                }
                // echo $value['billing_address']['name'];
                $trans = $this->shopify->shopify_call($shop->token_store, $shop->url_shopify, "/admin/api/2020-07/orders/".$value['id']."/transactions.json", array(), 'GET', $headerna);
                $trans = $trans['response'];
                $trans = json_decode($trans, JSON_PRETTY_PRINT);

                foreach ($trans['transactions'] as $t => $r) {
                    if ($r['status'] == 'success') {
                        // echo $r['message']." => ".$value['order_number']."<br>";
                        $message_trans = $r['message'];
                        $x_reference = $r['receipt']['x_reference'];
                    }
                }

                if($value['shipping_lines'][0]['title'] == 'Lion Parcel - Cash on Delivery (COD)'){
                    $x_reference = $value['fulfillments'][0]['tracking_number'];
                }

                // foreach ($value['payment_gateway_names'] as $pg => $pgn) {
                //     if($pgn == 'xendit'){
                //         if($message_trans == 'Payment Method : CREDIT_CARD'){
                //             $payment = "B";
                //         }
                //         else{
                //             $payment = "T";
                //         }
                //     }
                //     else{
                //         $payment = "T";
                //     }
                // }

                if($message_trans == 'Payment Method : CREDIT_CARD'){
                    $payment = "B";
                }
                else{
                    $payment = "T";
                }

                foreach ($value['shipping_lines'] as $s => $h) {
                    $cost = $h['price'];
                    $logistik = $h['title'];
                    if($h['discount_allocations'] != null){
                        foreach ($h['discount_allocations'] as $sd => $da) {
                            $cost = $cost - $da['amount'];
                        } 
                    }
                    else{
                        $discount_shipping = 0;
                    }
                }

                foreach ($value['line_items'] as $d => $l) {
                    if($l['discount_allocations'] != null){
                       foreach ($l['discount_allocations'] as $di => $al) {
                            $discount = $al['amount'];
                            // echo $l['price']." ".$al['amount']."=>";
                            $net = $l['price'] - $discount;
                        } 
                    }
                    else{
                        $discount = 0;
                        $net = $l['price'];
                    }
                    
                    foreach ($produk['products'] as $p => $r) {
                        foreach ($r['variants'] as $v => $s) {
                            if($l['product_id'] == $s['product_id']){
                                // echo $s[''];
                                if($s['compare_at_price'] != null){
                                    if($s['compare_at_price'] > $s['price']){
                                        $tag_price = $s['compare_at_price'];
                                        $reduction = $s['compare_at_price'] - $s['price'];
                                    }
                                    else{
                                        $reduction = 0;
                                        $tag_price = $l['price'];
                                    }
                                }
                                else{
                                    $reduction = 0;
                                    $tag_price = $l['price'];
                                }

                                // echo $l['title']." => product tag price (".$tag_price.")"." => potongan (".$reduction.")"."<br>";

                            }
                            break;
                        }
                    }

                    $created_result = substr($value['created_at'], 0, strpos($value['created_at'], "T"));
                    $newDate = date("d-m-y", strtotime($created_result));
                    $created = str_replace('-', '.', $newDate);

                    $data_order[] = array(
                        'order_number' => $value['order_number'],
                        'created_at' => $created,
                        'name' => $value['billing_address']['name'],
                        'sku' => (string)$l['sku'],
                        'product_name' => $l['name'],
                        'quantity' => $l['quantity'],
                        'price' => utf8_encode(money_format('%.0n', $value['total_price'])),
                        'tag_price' => utf8_encode(money_format('%.0n', $tag_price)),
                        'reduction' => utf8_encode(money_format('%.0n', $reduction)),
                        'net' => utf8_encode(money_format('%.0n', $net)),
                        'voucher' => utf8_encode(money_format('%.0n', $discount)),
                        // 'address1' => $value['customer']['default_address']['address1'],
                        // 'address2' => $value['customer']['default_address']['address2'],
                        // 'province' => $value['customer']['default_address']['province'],
                        // 'zip' => $value['customer']['default_address']['zip'],
                        // 'city' => $value['customer']['default_address']['city'],
                        // 'country' => $value['customer']['default_address']['country'],
                        // 'phone' => $value['customer']['default_address']['phone'],
                        'customer_name' => $value['billing_address']['name'],
                        'receiver_name' => $value['shipping_address']['name'],
                        'receiver_address' => $value['shipping_address']['address1'].", ".$value['shipping_address']['address2'],
                        'receiver_city' => $value['shipping_address']['city'],
                        'receiver_province' => $value['shipping_address']['province'],
                        'receiver_country' => $value['shipping_address']['country'],
                        'receiver_zip' => $value['shipping_address']['zip'],
                        'receiver_phone' => $value['shipping_address']['phone'],
                        'shipping_cost' => utf8_encode(money_format('%.0n', $cost)),
                        'logistik' => $logistik,
                        'payment' => $payment,
                        'card_type' => $card_type,
                        'card_number' => $card_number,
                        'reference' => $x_reference
                    );
                    $idna .= $l['product_id'].",";
                }
            }
        }

        $data['orders'] = $data_order;

        // foreach ($data['orders'] as $key => $value) {
        //  echo $value['sku'];
        // }

        // $object = new PHPExcel();

        // $object->getProperties()->setCreator('Report Colorbox');
        // $object->getProperties()->setLastModifiedBy('Report Colorbox');
        // $object->getProperties()->setTitle('Report Orders');

        // $object->setActiveSheetIndex(0);

        // $object->getActiveSheet()->setCellValue('A1', 'Brand');
        // $object->getActiveSheet()->setCellValue('B1', 'No Order');
        // $object->getActiveSheet()->setCellValue('C1', 'Order Date');
        // $object->getActiveSheet()->setCellValue('D1', 'Customer Name');
        // $object->getActiveSheet()->setCellValue('E1', 'Brand');
        // $object->getActiveSheet()->setCellValue('F1', 'SKU');
        // $object->getActiveSheet()->setCellValue('G1', 'Article Detail');
        // $object->getActiveSheet()->setCellValue('H1', 'Qty');
        // $object->getActiveSheet()->setCellValue('I1', 'Amount');
        // $object->getActiveSheet()->setCellValue('J1', 'Tag price ecomm');
        // $object->getActiveSheet()->setCellValue('K1', 'Reduction ecomm');
        // $object->getActiveSheet()->setCellValue('L1', 'Voucher ecomm');
        // $object->getActiveSheet()->setCellValue('M1', 'Net Amount');
        // $object->getActiveSheet()->setCellValue('N1', 'Shipping Cost');
        // $object->getActiveSheet()->setCellValue('O1', 'Logistik');
        // $object->getActiveSheet()->setCellValue('P1', 'Payment');
        // $object->getActiveSheet()->setCellValue('Q1', 'Card Type');
        // $object->getActiveSheet()->setCellValue('R1', 'CC No');
        // $object->getActiveSheet()->setCellValue('S1', 'Bank');
        // $object->getActiveSheet()->setCellValue('T1', "Receiver's name");
        // $object->getActiveSheet()->setCellValue('U1', 'Address');
        // $object->getActiveSheet()->setCellValue('V1', 'City');
        // $object->getActiveSheet()->setCellValue('W1', 'Province');
        // $object->getActiveSheet()->setCellValue('X1', 'Country');
        // $object->getActiveSheet()->setCellValue('Y1', 'Postal Code');
        // $object->getActiveSheet()->setCellValue('Z1', 'Phone Number');
        // $object->getActiveSheet()->setCellValue('AA1', 'Xendit reference');

        // $baris = 2;
        // $no = 1;

        // foreach ($data['orders'] as $key => $value) {
        //     $object->getActiveSheet()->setCellValue('A'.$baris, '700005');
        //     $object->getActiveSheet()->setCellValue('B'.$baris, $value['order_number']);
        //     $object->getActiveSheet()->setCellValue('C'.$baris, $value['created_at']);
        //     $object->getActiveSheet()->setCellValue('D'.$baris, $value['customer_name']);
        //     $object->getActiveSheet()->setCellValue('E'.$baris, 'Colorbox');
        //     $object->getActiveSheet()->setCellValue('F'.$baris, " ".$value['sku']." ");
        //     $object->getActiveSheet()->setCellValue('G'.$baris, $value['product_name']);
        //     $object->getActiveSheet()->setCellValue('H'.$baris, $value['quantity']);
        //     $object->getActiveSheet()->setCellValue('I'.$baris, $value['price']);
        //     $object->getActiveSheet()->setCellValue('J'.$baris, $value['tag_price']);
        //     $object->getActiveSheet()->setCellValue('K'.$baris, $value['reduction']);
        //     $object->getActiveSheet()->setCellValue('L'.$baris, $value['voucher']);
        //     $object->getActiveSheet()->setCellValue('M'.$baris, $value['net']);
        //     $object->getActiveSheet()->setCellValue('N'.$baris, $value['shipping_cost']);
        //     $object->getActiveSheet()->setCellValue('O'.$baris, $value['logistik']);
        //     $object->getActiveSheet()->setCellValue('P'.$baris, $value['payment']);
        //     $object->getActiveSheet()->setCellValue('Q'.$baris, $value['card_type']);
        //     $object->getActiveSheet()->setCellValue('R'.$baris, $value['card_number']);
        //     $object->getActiveSheet()->setCellValue('S'.$baris, '');
        //     $object->getActiveSheet()->setCellValue('T'.$baris, $value['receiver_name']);
        //     $object->getActiveSheet()->setCellValue('U'.$baris, $value['receiver_address']);
        //     $object->getActiveSheet()->setCellValue('V'.$baris, $value['receiver_city']);
        //     $object->getActiveSheet()->setCellValue('W'.$baris, $value['receiver_province']);
        //     $object->getActiveSheet()->setCellValue('X'.$baris, $value['receiver_country']);
        //     $object->getActiveSheet()->setCellValue('Y'.$baris, $value['receiver_zip']);
        //     $object->getActiveSheet()->setCellValue('Z'.$baris, $value['receiver_phone']);
        //     $object->getActiveSheet()->setCellValue('AA'.$baris, " ".$value['reference']." ");

        //     $baris++;
        // }

        // $object->getActiveSheet()->setTitle('Report Colorbox');

        // $filename = "Report_Order".'.xlsx';

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0');

        // $writer=PHPExcel_IOFactory::createwriter($object, 'Excel2007');
        // $writer->save('php://output');

        if($opsi == 'proses'){
            if(!empty($order['orders'])){
                foreach ($order['orders'] as $key => $value) {
                    if ($value['shipping_lines'][0]['title'] == 'Lion Parcel - Cash on Delivery (COD)') {
                        $order_tags = array(
                            "order" => array (
                                "tags" => 'order_cod,sudah_proses'
                            )
                        );
                    }
                    else{
                        $order_tags = array(
                            "order" => array (
                                "tags" => 'sudah_proses'
                            )
                        );
                    }
                    $tagna = $this->shopify->shopify_call($shop->token_store, $shop->url_shopify, "/admin/api/2020-07/orders/".$value.".json", $order_tags, 'PUT');
                    $tagna = $tagna['response'];
                    $tagna = json_decode($tagna, JSON_PRETTY_PRINT);
                }
            }
        }

        exit;
    }

    public function export_excel(){
        extract($_POST);
        require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
        
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

        $shop = $this->db->get_where('merchant_data', array('url_shopify' => $shop))->row();

        $id = $ids;
        $id_tag = explode(',', $id);

        $order = $this->shopify->api_get($shop->url_shopify, 'orders.json?status=any&ids='.$id, $shop->token_store);
        $order = json_decode($order, TRUE);

        $data_order = array();
        $datana = array();
        $variantna = '';

        $card_type = '';
        $card_number = '';
        $idna = '';
        $tag_price = 0;
        $total_discount = 0;
        $discount = 0;
        $discount_shipping = 0;
        $reduction = 0;
        $net = 0;

        $no = 1;
        $nona = 1;

        $data_valid = array();

        if(!empty($order['orders'])){
            foreach ($order['orders'] as $key => $value) {
                foreach ($value['line_items'] as $d => $l) {
                    if (!in_array($l['product_id'], array_column($data_valid, 'idna'))) {
                        $data_valid[] = array(
                            'idna' => $l['product_id'],
                            'qty' => $l['quantity'],
                            'orderna' => $value['name']
                        ); 
                    }
                }
            }
        }

        foreach ($data_valid as $key => $value) {
            // echo $no++."=>".$value['idna']."=>".$value['qty']."=>".$value['orderna']."<br>";
            $idna .= $value['idna'].",";
        }

        $produk = $this->shopify->shopify_call($shop->token_store, $shop->url_shopify, "/admin/api/2020-07/products.json?limit=250&ids=".$idna, array(), 'GET', $headerna);
        $produk = $produk['response'];
        $produk = json_decode($produk, JSON_PRETTY_PRINT);

        // foreach ($produk['products'] as $p => $r) {
        //  echo $nona++."=>".$r['id']."<br>";
        // }

        $message_trans = '';
        $x_reference = '';


        if(!empty($order['orders'])){
            foreach ($order['orders'] as $key => $value) {

                if($value['shipping_lines'][0]['code'] == 'REG_ASURANSI'){
                    $insurance = 'Y';
                }
                else{
                    $insurance = 'N';
                }
                // echo $value['billing_address']['name'];
                $trans = $this->shopify->shopify_call($shop->token_store, $shop->url_shopify, "/admin/api/2020-07/orders/".$value['id']."/transactions.json", array(), 'GET', $headerna);
                $trans = $trans['response'];
                $trans = json_decode($trans, JSON_PRETTY_PRINT);

                foreach ($trans['transactions'] as $t => $r) {
                    if ($r['status'] == 'success') {
                        // echo $r['message']." => ".$value['order_number']."<br>";
                        $message_trans = $r['message'];
                        $x_reference = $r['receipt']['x_reference'];
                    }
                }

                if($value['shipping_lines'][0]['title'] == 'Lion Parcel - Cash on Delivery (COD)'){
                    if($value['fulfillments'] != null){
                        $x_reference = $value['fulfillments'][0]['tracking_number'];
                    }
                }

                // foreach ($value['payment_gateway_names'] as $pg => $pgn) {
                //     if($pgn == 'xendit'){
                        
                //     }
                //     else{
                //         $payment = "T";
                //     }
                // }

                if($message_trans == 'Payment Method : CREDIT_CARD'){
                    $payment = "B";
                }
                else{
                    $payment = "T";
                }

                $free_shipping = false;

                foreach ($value['shipping_lines'] as $s => $h) {
                    $cost = $h['price'];
                    $logistik = $h['title'];
                    if($h['discount_allocations'] != null){
                        // echo "<pre>";
                        // var_dump($h['discount_allocations']);
                        // echo "</pre>";
                        foreach ($h['discount_allocations'] as $sd => $da) {
                            $cost = $cost - $da['amount'];
                            $free_shipping = true;
                        } 
                    }
                    else{
                        $discount_shipping = 0;
                    }
                }

                foreach ($value['line_items'] as $d => $l) {
                    if($l['discount_allocations'] != null){
                       foreach ($l['discount_allocations'] as $di => $al) {
                            $discount = $al['amount'];
                            // echo $l['price']." ".$al['amount']."=>";
                            // $net = $l['price'] - $discount;
                            $net = $l['price'];

                            // echo $l['price']." - ".$discount." = ".$net."<br>";
                        } 
                    }
                    else{
                        $discount = 0;
                        $net = $l['price'];
                    }
                    
                    foreach ($produk['products'] as $p => $r) {
                        foreach ($r['variants'] as $v => $s) {
                            if($l['product_id'] == $s['product_id']){
                                // echo $s[''];
                                if($s['compare_at_price'] != null){
                                    if($s['compare_at_price'] > $s['price']){
                                        $tag_price = $s['compare_at_price'];
                                        $reduction = $s['compare_at_price'] - $s['price'];
                                    }
                                    else{
                                        $reduction = 0;
                                        $tag_price = $l['price'];
                                    }
                                }
                                else{
                                    $reduction = 0;
                                    $tag_price = $l['price'];
                                }

                                // echo $l['title']." => product tag price (".$tag_price.")"." => potongan (".$reduction.")"."<br>";

                            }
                            break;
                        }
                    }
                    
                    $created_result = substr($value['created_at'], 0, strpos($value['created_at'], "T"));
                    $newDate = date("d-m-y", strtotime($created_result));
                    $created = str_replace('-', '.', $newDate);

                    if($free_shipping == true){
                        $vch = 0;
                    }
                    else{
                        $vch = str_replace('.00', '', $value['total_discounts']);
                    }

                    // utf8_encode(money_format('%.0n', $discount))

                    $data_order[] = array(
                        'order_number' => $value['order_number'],
                        'created_at' => $created,
                        'name' => $value['billing_address']['name'],
                        'sku' => (string)$l['sku'],
                        'product_name' => $l['name'],
                        'quantity' => $l['quantity'],
                        'price' => utf8_encode(money_format('%.0n', $value['total_price'])),
                        'tag_price' => utf8_encode(money_format('%.0n', $tag_price)),
                        'reduction' => utf8_encode(money_format('%.0n', $reduction)),
                        'net' => utf8_encode(money_format('%.0n', $net)),
                        'voucher' => $vch,
                        // 'address1' => $value['customer']['default_address']['address1'],
                        // 'address2' => $value['customer']['default_address']['address2'],
                        // 'province' => $value['customer']['default_address']['province'],
                        // 'zip' => $value['customer']['default_address']['zip'],
                        // 'city' => $value['customer']['default_address']['city'],
                        // 'country' => $value['customer']['default_address']['country'],
                        // 'phone' => $value['customer']['default_address']['phone'],
                        'customer_name' => $value['billing_address']['name'],
                        'receiver_name' => $value['shipping_address']['name'],
                        'receiver_address' => $value['shipping_address']['address1'].", ".$value['shipping_address']['address2'],
                        'receiver_city' => $value['shipping_address']['city'],
                        'receiver_province' => $value['shipping_address']['province'],
                        'receiver_country' => $value['shipping_address']['country'],
                        'receiver_zip' => $value['shipping_address']['zip'],
                        'receiver_phone' => $value['shipping_address']['phone'],
                        'shipping_cost' => utf8_encode(money_format('%.0n', $cost)),
                        'logistik' => $logistik,
                        'payment' => $payment,
                        'card_type' => $card_type,
                        'card_number' => $card_number,
                        'reference' => $x_reference,
                        'insurance' => $insurance
                    );
                    $idna .= $l['product_id'].",";
                }
            }
        }

        $data['orders'] = $data_order;

        // foreach ($data['orders'] as $key => $value) {
        //  echo $value['sku'];
        // }

        $object = new PHPExcel();

        $object->getProperties()->setCreator('Report Colorbox');
        $object->getProperties()->setLastModifiedBy('Report Colorbox');
        $object->getProperties()->setTitle('Report Orders');

        $object->setActiveSheetIndex(0);

        $object->getActiveSheet()->setCellValue('A1', 'Brand');
        $object->getActiveSheet()->setCellValue('B1', 'No Order');
        $object->getActiveSheet()->setCellValue('C1', 'Order Date');
        $object->getActiveSheet()->setCellValue('D1', 'Customer Name');
        $object->getActiveSheet()->setCellValue('E1', 'Brand');
        $object->getActiveSheet()->setCellValue('F1', 'SKU');
        $object->getActiveSheet()->setCellValue('G1', 'Article Detail');
        $object->getActiveSheet()->setCellValue('H1', 'Qty');
        $object->getActiveSheet()->setCellValue('I1', 'Amount');
        $object->getActiveSheet()->setCellValue('J1', 'Tag price ecomm');
        $object->getActiveSheet()->setCellValue('K1', 'Reduction ecomm');
        $object->getActiveSheet()->setCellValue('L1', 'Voucher ecomm');
        $object->getActiveSheet()->setCellValue('M1', 'Net Amount');
        $object->getActiveSheet()->setCellValue('N1', 'Shipping Cost');
        $object->getActiveSheet()->setCellValue('O1', 'Logistik');
        $object->getActiveSheet()->setCellValue('P1', 'Payment');
        $object->getActiveSheet()->setCellValue('Q1', 'Card Type');
        $object->getActiveSheet()->setCellValue('R1', 'CC No');
        $object->getActiveSheet()->setCellValue('S1', 'Bank');
        $object->getActiveSheet()->setCellValue('T1', "Receiver's name");
        $object->getActiveSheet()->setCellValue('U1', 'Address');
        $object->getActiveSheet()->setCellValue('V1', 'City');
        $object->getActiveSheet()->setCellValue('W1', 'Province');
        $object->getActiveSheet()->setCellValue('X1', 'Country');
        $object->getActiveSheet()->setCellValue('Y1', 'Postal Code');
        $object->getActiveSheet()->setCellValue('Z1', 'Phone Number');
        $object->getActiveSheet()->setCellValue('AA1', 'Xendit reference');
        $object->getActiveSheet()->setCellValue('AB1', 'Insurance');

        $baris = 2;
        $no = 1;
        $array_baru = array();

        $sort = array();
        $sort_number = array();
        foreach ($data['orders'] as $key => $value) {
            $sort['net'][$key] = $value['net'];
            $sort_number['order_number'][$key] = $value['order_number'];
        }
        array_multisort(array_column($data['orders'], 'order_number'),  SORT_DESC, array_column($data['orders'], 'net'), SORT_DESC, $data['orders']);
        $baru = $data['orders'];

        $prev = 0;
        $res = 0;

        foreach ($baru as $key => $value) {
            // if ($display == true){
            //     $value['voucher'] = $value['voucher'];
            //     $value['net'] = $value['net'] - $value['voucher'];
            // }
            // else{
            //     $value['voucher'] = 0;
            // }

            if($value['quantity'] > 1){
                $quantity = 1;
            }
            else{
                $quantity = $value['quantity'];
            }
            
            for($i = 1; $i <= $value['quantity']; $i++){

                $value['logistik'] = str_replace(" Tanpa Asuransi", "", $value['logistik']);
                $value['logistik'] = str_replace(" Ditambah Asuransi", "", $value['logistik']);
                // $display = false;
                                
                // if(!in_array($value['order_number'], $array_baru)){
                //     $array_baru[] = $value['order_number'];
                //     $display = true;
                // }

                if($prev != $value['voucher']){
                    if($res < 0){
                        $pocer = $prev;
                        $diskonna = $prev;
                    }
                    else{
                        $pocer = $value['voucher'];
                        $diskonna = $value['voucher'];
                    }
                }
                else{
                    $diskonna = 0;
                }

                $result = $value['net'] - $diskonna;
                
                if($result < 0){
                    $res = $result;
                    $rmv_min = str_replace("-", "", $result);
                    $prev = $rmv_min;
                    $result = 0;
                    $diskonna = $value['net'];
                }
                else{
                    $res = $result;
                    $rmv_min = str_replace("-", "", $result);
                    $prev = $value['voucher'];
                }

                $object->getActiveSheet()->setCellValue('A'.$baris, '700005');
                $object->getActiveSheet()->setCellValue('B'.$baris, $value['order_number']);
                $object->getActiveSheet()->setCellValue('C'.$baris, $value['created_at']);
                $object->getActiveSheet()->setCellValue('D'.$baris, $value['customer_name']);
                $object->getActiveSheet()->setCellValue('E'.$baris, 'Colorbox');
                $object->getActiveSheet()->setCellValue('F'.$baris, " ".$value['sku']." ");
                $object->getActiveSheet()->setCellValue('G'.$baris, $value['product_name']);
                $object->getActiveSheet()->setCellValue('H'.$baris, $quantity);
                $object->getActiveSheet()->setCellValue('I'.$baris, $value['price']);
                $object->getActiveSheet()->setCellValue('J'.$baris, $value['tag_price']);
                $object->getActiveSheet()->setCellValue('K'.$baris, $value['reduction']);
                $object->getActiveSheet()->setCellValue('L'.$baris, $diskonna);
                $object->getActiveSheet()->setCellValue('M'.$baris, $result);
                $object->getActiveSheet()->setCellValue('N'.$baris, $value['shipping_cost']);
                $object->getActiveSheet()->setCellValue('O'.$baris, $value['logistik']);
                $object->getActiveSheet()->setCellValue('P'.$baris, $value['payment']);
                $object->getActiveSheet()->setCellValue('Q'.$baris, $value['card_type']);
                $object->getActiveSheet()->setCellValue('R'.$baris, $value['card_number']);
                $object->getActiveSheet()->setCellValue('S'.$baris, '');
                $object->getActiveSheet()->setCellValue('T'.$baris, $value['receiver_name']);
                $object->getActiveSheet()->setCellValue('U'.$baris, $value['receiver_address']);
                $object->getActiveSheet()->setCellValue('V'.$baris, $value['receiver_city']);
                $object->getActiveSheet()->setCellValue('W'.$baris, $value['receiver_province']);
                $object->getActiveSheet()->setCellValue('X'.$baris, $value['receiver_country']);
                $object->getActiveSheet()->setCellValue('Y'.$baris, $value['receiver_zip']);
                $object->getActiveSheet()->setCellValue('Z'.$baris, $value['receiver_phone']);
                $object->getActiveSheet()->setCellValue('AA'.$baris, " ".$value['reference']." ");
                $object->getActiveSheet()->setCellValue('AB'.$baris, " ".$value['insurance']." ");

                $baris++;
            }
        }

        $object->getActiveSheet()->setTitle('Report Colorbox');

        $filename = "Report_Order".'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer=PHPExcel_IOFactory::createwriter($object, 'Excel2007');
        $writer->save('php://output');

        if($opsi == 'proses'){
            if(!empty($order['orders'])){
                foreach ($order['orders'] as $key => $value) {
                    if ($value['shipping_lines'][0]['title'] == 'Lion Parcel - Cash on Delivery (COD)') {
                        if($value['tags'] == 'order_cod, payment_processed'){
                            $order_tags = array(
                                "order" => array (
                                    "tags" => 'order_cod,sudah_proses,payment_processed'
                                )
                            );
                        }
                        else{
                            $order_tags = array(
                                "order" => array (
                                    "tags" => 'order_cod,sudah_proses'
                                )
                            );
                        }
                    }
                    else{
                        if($value['tags'] == 'payment_processed'){
                            $order_tags = array(
                                "order" => array (
                                    "tags" => 'sudah_proses,payment_processed'
                                )
                            );
                        }
                        else{
                            $order_tags = array(
                                "order" => array (
                                    "tags" => 'sudah_proses'
                                )
                            );
                        }
                    }
                    $tagna = $this->shopify->shopify_call($shop->token_store, $shop->url_shopify, "/admin/api/2020-07/orders/".$value['id'].".json", $order_tags, 'PUT');
                    $tagna = $tagna['response'];
                    $tagna = json_decode($tagna, JSON_PRETTY_PRINT);
                }
            }
        }

        exit; 
    }

}
