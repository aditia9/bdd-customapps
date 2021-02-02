<html>
    <head>
        <title>Tracking Order</title>
        <?php $this->load->view('css-js/css'); ?>
    </head>
    <body class="scroll">
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="navbar-collapse justify-content-center" id="navbarNav">
                <p class="text-white m-0 p-2 text-center">Report Orders</p>
            </div>
        </nav>
        <div class="p-3">
            <!-- <?=$shop->url_shopify;?>
            <?=$ids;?> -->
            <h4>Report Orders</h4>

           <!--  <?php
                $new_na = $orders;
                $prev = 0;
                $res = 0;
                $net = 15000;
                foreach ($new_na as $key => $value) {

                    if($prev != $value['voucher']){
                        if($res < 0){
                            $pocer = $prev;
                        }
                        else{
                            $pocer = $value['voucher'];
                        }
                    }
                    else{
                        $pocer = 0;
                    }

                    $result = $net - $pocer;
                    
                    if($result < 0){
                        $res = $result;
                        $rmv_min = str_replace("-", "", $result);
                        $prev = $rmv_min;
                        $result = 0;
                    }
                    else{
                        $res = $result;
                        $rmv_min = str_replace("-", "", $result);
                        $prev = $orders[$key]['voucher'];
                    }

                    echo $value['order_number']." : ".$net." - ".$pocer." => ".$result." => ".$prev."<br>";
                    $net += 10000;
                }
            ?> -->


            <form action="<?=site_url('config/export_excel');?>" method="post">
                <input type="hidden" name="shop" value="<?=$shop->url_shopify;?>">
                <input type="hidden" name="ids" value="<?=$ids;?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group pl-0">
                            <select name="opsi" class="form-control">
                                <option value="jangan_proses">Jangan Proses</option>
                                <option value="proses">Proses</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group pl-0">
                            <input type="submit" name="submit" value="Export to excel" class="btn btn-success mb-3">
                        </div>
                    </div>
                </div>
            </form>

            <?php
                $sort = array();
                $sort_number = array();
                $tes = array();
                foreach ($orders as $key => $value) {
                    $sort['net'][$key] = $value['net'];
                    $sort_number['order_number'][$key] = $value['order_number'];
                }

                array_multisort(array_column($orders, 'order_number'),  SORT_DESC, array_column($orders, 'net'), SORT_DESC, $orders);
                $baru = $orders;
            ?>

            <div class="table-responsive" id="content-print">
                <table class="table bg-white table-report">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>No Order</th>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th>Brand</th>
                            <th>SKU</th>
                            <th>Article Detail</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Tag price ecomm</th>
                            <th>Reduction ecomm</th>
                            <th>Voucher ecomm</th>
                            <th>Net Amount</th>
                            <th>Shipping Cost</th>
                            <th>Logistik</th>
                            <th>Payment</th>
                            <th>Card Type</th>
                            <th>CC No</th>
                            <th>Bank</th>
                            <th>Receiver's name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Province</th>
                            <th>Country</th>
                            <th>Postal Code</th>
                            <th>Phone Number</th>
                            <th>Xendit reference</th>
                            <th>Insurance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no2 = 1;
                            $array_baru = array();
                            $array_tes = 0;
                            $prev = 0;
                            $res = 0;
                            // rsort($orders);
                            foreach ($orders as $key => $value) {

                                if($value['quantity'] > 1){
                                    $quantity = 1;
                                }
                                else{
                                    $quantity = $value['quantity'];
                                }
                                // echo json_encode($array_baru);
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
                                        $prev = $orders[$key]['voucher'];
                                    }
                        ?>
                        <tr>
                            <td>700005</td>
                            <td><?=$value['order_number'];?></td>
                            <td><?=$value['created_at'];?></td>
                            <td><?=$value['customer_name'];?></td>
                            <td>Colorbox</td>
                            <td><?=$value['sku'];?></td>
                            <td><?=$value['product_name'];?></td>
                            <td><?=$quantity;?></td>
                            <td><?=$value['price'];?></td>
                            <td><?=$value['tag_price']?></td>
                            <td><?=$value['reduction']?></td>
                            <td>
                                <!-- <?php echo $value['net'] ?> -->
                                <!-- <?php if ($display == true): ?>
                                    <?php echo $value['voucher']; ?>
                                    <?php $net = $value['net'] - $value['voucher']; ?>
                                <?php else: ?>
                                    <?php $net = $value['net']; ?>
                                    0
                                <?php endif ?> -->
                                <?php echo $diskonna ?>
                            </td>
                            <td><?=$result?></td>
                            <td><?=$value['shipping_cost'];?></td>
                            <td><?=$value['logistik'];?></td>
                            <td><?=$value['payment']?></td>
                            <td><?=$value['card_type'];?></td>
                            <td><?=$value['card_number'];?></td>
                            <td></td>
                            <td><?=$value['receiver_name'];?></td>
                            <td><?=$value['receiver_address'];?></td>
                            <td><?=$value['receiver_city'];?></td>
                            <td><?=$value['receiver_province'];?></td>
                            <td><?=$value['receiver_country'];?></td>
                            <td><?=$value['receiver_zip'];?></td>
                            <td><?=$value['receiver_phone'];?></td>
                            <td><?=$value['reference'];?></td>
                            <td><?=$value['insurance']?></td>
                        </tr>
                        <?php 
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php $this->load->view('css-js/js'); ?>
    </body>
</html>