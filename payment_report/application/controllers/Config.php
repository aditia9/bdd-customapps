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
        $release_payment = '';
        $awb = '';
        $payment_method = '';
        $seller_name = '';
        $xendit_fee = 0;
        $payment_date = '-';

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

                $created_result = substr($value['created_at'], 0, strpos($value['created_at'], "T"));
                $newDate = date("d-m-y", strtotime($created_result));
                $created = str_replace('-', '.', $newDate);

                foreach ($trans['transactions'] as $t => $r) {
                    if ($r['status'] == 'success') {
                        // echo $r['message']." => ".$value['order_number']."<br>";
                        $message_trans = $r['message'];
                        $release_payment = $r['processed_at'];

                        $payment_method = str_replace("Payment Method : ", "", $message_trans);
                        $payment_method = str_replace("VIRTUAL_ACCOUNT", "Virtual Account", $payment_method);
                        
                        $seller_name = str_replace("Virtual Account ", "", $payment_method);

                        $total_untuk_diskon = utf8_encode(money_format('%.0n', $value['total_price']));

                        // echo $value['order_number']." dan ".$seller_name;
                        $release_payment = substr($release_payment, 0, strpos($release_payment, "T"));
                        $release_payment = date("d-m-Y", strtotime($release_payment));
                        $release_payment = str_replace('-', '.', $release_payment);

                        $payment_date = $created;

                        if($seller_name == 'CREDIT_CARD'){
                            $payment_method = str_replace("CREDIT_CARD", "Credit Card", $payment_method);
                            $seller_name = str_replace("CREDIT_CARD", "Credit Card", $payment_method);
                            $fee = (2.90 / 100) * $total_untuk_diskon;
                            $fee = $fee + 2000;
                            if(strpos($fee, ".")){
                                $fee = substr($fee, 0, strpos($fee, "."));
                            }
                            $xendit_fee = $fee;
                        }
                        else if($seller_name == 'BRI' || $seller_name == 'BNI' || $seller_name == 'PERMATA' || $seller_name == 'MANDIRI'){
                            $xendit_fee = 4500;
                        }
                        else{
                            $payment_method = 'Shopee Pay';
                            $seller_name = 'Shopee Pay';
                            $fee = (1.50 / 100) * $total_untuk_diskon;
                            if(strpos($fee, ".")){
                                $fee = substr($fee, 0, strpos($fee, "."));
                            }
                            $xendit_fee = $fee;
                        }
                    }
                    else{
                        $xendit_fee = 0;
                        $release_payment = '-';
                        $payment_date = '-';
                    }
                }


                if($value['gateway'] == 'shopeepay_xendit_'){
                    $payment_method = 'Shopee Pay';
                    $seller_name = 'Shopee Pay';
                }

                if($value['fulfillments'] != null){
                    $awb = $value['fulfillments'][0]['tracking_number'];
                }
                else{
                    $awb = '';
                }

                $free_shipping = false;

                foreach ($value['shipping_lines'] as $s => $h) {
                    $cost = $h['price'];
                    $logistik = $h['title'];
                    // if($h['discount_allocations'] != null){
                    //     foreach ($h['discount_allocations'] as $sd => $da) {
                    //         $cost = $cost - $da['amount'];
                    //         $free_shipping = true;
                    //     } 
                    // }
                    // else{
                    //     $discount_shipping = 0;
                    // }
                }

                foreach ($value['line_items'] as $d => $l) {
                    if($l['discount_allocations'] != null){
                       foreach ($l['discount_allocations'] as $di => $al) {
                            $discount = $al['amount'];
                            $net = $l['price'];
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

                                if($s['price'] == $l['price']){
                                    if($s['compare_at_price'] != null){
                                        if($s['compare_at_price'] > $s['price']){
                                            $tag_price = $s['compare_at_price'];
                                            // $reduction = $s['compare_at_price'] - $s['price'];
                                        }
                                        else{
                                            // $reduction = 0;
                                            $tag_price = $l['price'];
                                        }
                                    }
                                    else{
                                        // $reduction = 0;
                                        $tag_price = $l['price'];
                                    }
                                }
                                else{
                                    $tag_price = $l['price'];
                                }
                            }

                            break;
                        }
                    }

                    // if($free_shipping == true){
                    //     $vch = 0;
                    // }
                    // else{
                    $vch = str_replace('.00', '', $value['total_discounts']);
                    // }

                    $data_order[] = array(
                        'order_number' => utf8_encode(money_format('%.0n', $value['order_number'])),
                        'created_at' => $created,
                        'name' => $value['billing_address']['name'],
                        'sku' => (string)$l['sku'],
                        'product_name' => $l['name'],
                        'quantity' => $l['quantity'],
                        'price' => utf8_encode(money_format('%.0n', $value['total_price'])),
                        'tag_price' => utf8_encode(money_format('%.0n', $tag_price)),
                        'voucher' => $vch,
                        'net' => utf8_encode(money_format('%.0n', $net)),
                        'customer_name' => $value['billing_address']['name'],
                        'shipping_cost' => utf8_encode(money_format('%.0n', $cost)),
                        'release_payment' => $release_payment,
                        'payment_method' => $payment_method,
                        'payment_date' => $payment_date,
                        'seller_name' => $seller_name,
                        'awb' => $awb,
                        'xendit_fee' => $xendit_fee
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
        $release_payment = '';
        $awb = '';
        $payment_method = '';
        $seller_name = '';
        $xendit_fee = 0;
        $payment_date = '-';

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

                $created_result = substr($value['created_at'], 0, strpos($value['created_at'], "T"));
                $newDate = date("d-m-y", strtotime($created_result));
                $created = str_replace('-', '.', $newDate);

                foreach ($trans['transactions'] as $t => $r) {
                    if ($r['status'] == 'success') {
                        // echo $r['message']." => ".$value['order_number']."<br>";
                        $message_trans = $r['message'];
                        $release_payment = $r['processed_at'];

                        $payment_method = str_replace("Payment Method : ", "", $message_trans);
                        $payment_method = str_replace("VIRTUAL_ACCOUNT", "Virtual Account", $payment_method);
                        
                        $seller_name = str_replace("Virtual Account ", "", $payment_method);

                        $total_untuk_diskon = utf8_encode(money_format('%.0n', $value['total_price']));

                        // echo $value['order_number']." dan ".$seller_name;
                        $release_payment = substr($release_payment, 0, strpos($release_payment, "T"));
                        $release_payment = date("d-m-Y", strtotime($release_payment));
                        $release_payment = str_replace('-', '.', $release_payment);

                        $payment_date = $created;

                        if($seller_name == 'CREDIT_CARD'){
                            $payment_method = str_replace("CREDIT_CARD", "Credit Card", $payment_method);
                            $seller_name = str_replace("CREDIT_CARD", "Credit Card", $payment_method);
                            $fee = (2.90 / 100) * $total_untuk_diskon;
                            $fee = $fee + 2000;
                            if(strpos($fee, ".")){
                                $fee = substr($fee, 0, strpos($fee, "."));
                            }
                            $xendit_fee = $fee;
                        }
                        else if($seller_name == 'BRI' || $seller_name == 'BNI' || $seller_name == 'PERMATA' || $seller_name == 'MANDIRI'){
                            $xendit_fee = 4500;
                        }
                        else{
                            $payment_method = 'Shopee Pay';
                            $seller_name = 'Shopee Pay';
                            $fee = (1.50 / 100) * $total_untuk_diskon;
                            if(strpos($fee, ".")){
                                $fee = substr($fee, 0, strpos($fee, "."));
                            }
                            $xendit_fee = $fee;
                        }
                    }
                    else{
                        $xendit_fee = 0;
                        $release_payment = '-';
                        $payment_date = '-';
                    }
                }


                if($value['gateway'] == 'shopeepay_xendit_'){
                    $payment_method = 'Shopee Pay';
                    $seller_name = 'Shopee Pay';
                }

                if($value['fulfillments'] != null){
                    $awb = $value['fulfillments'][0]['tracking_number'];
                }
                else{
                    $awb = '';
                }

                $free_shipping = false;

                foreach ($value['shipping_lines'] as $s => $h) {
                    $cost = $h['price'];
                    $logistik = $h['title'];
                    // if($h['discount_allocations'] != null){
                    //     foreach ($h['discount_allocations'] as $sd => $da) {
                    //         $cost = $cost - $da['amount'];
                    //         $free_shipping = true;
                    //     } 
                    // }
                    // else{
                    //     $discount_shipping = 0;
                    // }
                }

                foreach ($value['line_items'] as $d => $l) {
                    if($l['discount_allocations'] != null){
                       foreach ($l['discount_allocations'] as $di => $al) {
                            $discount = $al['amount'];
                            $net = $l['price'];
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
                                if($s['price'] == $l['price']){
                                    if($s['compare_at_price'] != null){
                                        if($s['compare_at_price'] > $s['price']){
                                            $tag_price = $s['compare_at_price'];
                                            // $reduction = $s['compare_at_price'] - $s['price'];
                                        }
                                        else{
                                            // $reduction = 0;
                                            $tag_price = $l['price'];
                                        }
                                    }
                                    else{
                                        // $reduction = 0;
                                        $tag_price = $l['price'];
                                    }
                                }
                                else{
                                    $tag_price = $l['price'];
                                }
                            }
                            break;
                        }
                    }

                    // if($free_shipping == true){
                    //     $vch = 0;
                    // }
                    // else{
                    $vch = str_replace('.00', '', $value['total_discounts']);
                    // }

                    $data_order[] = array(
                        'order_number' => utf8_encode(money_format('%.0n', $value['order_number'])),
                        'created_at' => $created,
                        'name' => $value['billing_address']['name'],
                        'sku' => (string)$l['sku'],
                        'product_name' => $l['name'],
                        'quantity' => $l['quantity'],
                        'price' => utf8_encode(money_format('%.0n', $value['total_price'])),
                        'tag_price' => utf8_encode(money_format('%.0n', $tag_price)),
                        'voucher' => $vch,
                        'net' => utf8_encode(money_format('%.0n', $net)),
                        'customer_name' => $value['billing_address']['name'],
                        'shipping_cost' => utf8_encode(money_format('%.0n', $cost)),
                        'release_payment' => $release_payment,
                        'payment_method' => $payment_method,
                        'payment_date' => $payment_date,
                        'seller_name' => $seller_name,
                        'awb' => $awb,
                        'xendit_fee' => $xendit_fee
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

        $object->getProperties()->setCreator('Report Payment Colorbox');
        $object->getProperties()->setLastModifiedBy('Report Payment');
        $object->getProperties()->setTitle('Report Payment');

        $object->setActiveSheetIndex(0);

        $object->getActiveSheet()->setCellValue('A1', 'Order No.');
        $object->getActiveSheet()->setCellValue('B1', 'Customer Name');
        $object->getActiveSheet()->setCellValue('C1', 'Order Date');
        $object->getActiveSheet()->setCellValue('D1', 'Payment Date');
        $object->getActiveSheet()->setCellValue('E1', 'Brand');
        $object->getActiveSheet()->setCellValue('F1', 'Article No');
        $object->getActiveSheet()->setCellValue('G1', 'Article Description');
        $object->getActiveSheet()->setCellValue('H1', 'Qty');
        $object->getActiveSheet()->setCellValue('I1', 'Price Tag');
        $object->getActiveSheet()->setCellValue('J1', 'Price Disc');
        $object->getActiveSheet()->setCellValue('K1', 'Discount');
        $object->getActiveSheet()->setCellValue('L1', 'Shipping Cost');
        $object->getActiveSheet()->setCellValue('M1', 'Total Amount');
        $object->getActiveSheet()->setCellValue('N1', 'Fee');
        $object->getActiveSheet()->setCellValue('O1', 'Net Amount');
        $object->getActiveSheet()->setCellValue('P1', 'Payment Method');
        $object->getActiveSheet()->setCellValue('Q1', 'Release Payment Date from Xendit');
        $object->getActiveSheet()->setCellValue('R1', 'Seller Bank Name');
        $object->getActiveSheet()->setCellValue('S1', 'Curr');
        $object->getActiveSheet()->setCellValue('T1', 'AWB/Shipment No');

        $sort = array();
        $sort_number = array();
        $tes = array();
        foreach ($data['orders'] as $key => $value) {
            $sort['net'][$key] = $value['net'];
            $sort_number['order_number'][$key] = $value['order_number'];
        }

        array_multisort(array_column($data['orders'], 'order_number'),  SORT_DESC, array_column($data['orders'], 'net'), SORT_DESC, $data['orders']);


        $baris = 2;
        $no = 1;
        $prev = 0;
        $prev_shipping = 0;
        $prev_price = 0;
        $prev_fee = 0;

        foreach ($data['orders'] as $key => $value) {

            $netna = $value['price'] - $value['xendit_fee'];

            if($value['quantity'] > 1){
                $quantity = 1;
            }
            else{
                $quantity = $value['quantity'];
            }
            // echo json_encode($array_baru);
            for($i = 1; $i <= $value['quantity']; $i++){

                if($prev != $value['voucher']){
                    $disc = $value['voucher'];

                    $prev = $value['voucher'];
                }
                else{
                    $disc = 0;
                }

                if($prev_shipping != $value['shipping_cost']){
                    $shipping_na = $value['shipping_cost'];

                    $prev_shipping = $value['shipping_cost'];
                }
                else{
                    $shipping_na = 0;
                }
                
                if($prev_fee != $value['xendit_fee']){
                    $xendit_fee = $value['xendit_fee'];

                    $prev_fee = $value['xendit_fee'];
                }
                else{
                    $xendit_fee = 0;
                }

                if($value['tag_price'] == $value['net']){
                    $value['net'] = 0;
                    $total_amount = ($value['tag_price'] - $disc) + $shipping_na;
                }
                else{
                    $total_amount = ($value['net'] - $disc) + $shipping_na;
                }

                $datena = date("d.m.Y");

                $object->getActiveSheet()->setCellValue('A'.$baris, $value['order_number']);
                $object->getActiveSheet()->setCellValue('B'.$baris, $value['customer_name']);
                $object->getActiveSheet()->setCellValue('C'.$baris, $value['created_at']);
                $object->getActiveSheet()->setCellValue('D'.$baris, $value['payment_date']);
                $object->getActiveSheet()->setCellValue('E'.$baris, 'Colorbox');
                $object->getActiveSheet()->setCellValue('F'.$baris, " ".$value['sku']." ");
                $object->getActiveSheet()->setCellValue('G'.$baris, $value['product_name']);
                $object->getActiveSheet()->setCellValue('H'.$baris, $quantity);
                $object->getActiveSheet()->setCellValue('I'.$baris, $value['tag_price']);
                $object->getActiveSheet()->setCellValue('J'.$baris, $value['net']);
                $object->getActiveSheet()->setCellValue('K'.$baris, $disc);
                $object->getActiveSheet()->setCellValue('L'.$baris, $shipping_na);
                $object->getActiveSheet()->setCellValue('M'.$baris, $total_amount);
                $object->getActiveSheet()->setCellValue('N'.$baris, $xendit_fee);
                $object->getActiveSheet()->setCellValue('O'.$baris, $value['price'] - $value['xendit_fee']);
                $object->getActiveSheet()->setCellValue('P'.$baris, $value['payment_method']);
                $object->getActiveSheet()->setCellValue('Q'.$baris, $value['release_payment']);
                $object->getActiveSheet()->setCellValue('R'.$baris, $value['seller_name']);
                $object->getActiveSheet()->setCellValue('S'.$baris, 'IDR');
                $object->getActiveSheet()->setCellValue('T'.$baris, $value['awb']);

                $baris++;
            }
        }

        $object->getActiveSheet()->setTitle('Payment Report');

        $filename = "Payment_Report".'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer=PHPExcel_IOFactory::createwriter($object, 'Excel2007');
        $writer->save('php://output');

        if($opsi == 'proses'){
            if(!empty($order['orders'])){
                foreach ($order['orders'] as $key => $value) {
                    if ($value['shipping_lines'][0]['title'] == 'Lion Parcel - Cash on Delivery (COD)') {
                        if($value['tags'] == 'order_cod, sudah_proses'){
                            $order_tags = array(
                                "order" => array (
                                    "tags" => 'order_cod,sudah_proses,payment_processed'
                                )
                            );
                        }
                        else{
                            $order_tags = array(
                                "order" => array (
                                    "tags" => 'order_cod,payment_processed'
                                )
                            );
                        }
                    }
                    else{
                        if($value['tags'] == 'sudah_proses'){
                            $order_tags = array(
                                "order" => array (
                                    "tags" => 'sudah_proses,payment_processed'
                                )
                            );
                        }
                        else{
                            $order_tags = array(
                                "order" => array (
                                    "tags" => 'payment_processed'
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
