<html>
    <head>
        <title>Tracking Order</title>
        <?php $this->load->view('css-js/css'); ?>
    </head>
    <body class="scroll">
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="navbar-collapse justify-content-center" id="navbarNav">
                <p class="text-white m-0 p-2 text-center">Payment Report</p>
            </div>
        </nav>
        <div class="p-3">
            <!-- <?=$shop->url_shopify;?>
            <?=$ids;?> -->
            <h4>Payment Report</h4>

            <form action="<?=site_url('config/export_excel');?>" method="post">
                <input type="hidden" name="shop" value="<?=$shop->url_shopify;?>">
                <input type="hidden" name="ids" value="<?=$ids;?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group pl-0">
                            <select name="opsi" class="form-control">
                                <option value="jangan_proses">Tidak tambah tag</option>
                                <option value="proses">Tambah tag payment_processed</option>
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

            <div class="table-responsive" id="content-print">
                <table class="table bg-white table-report">
                    <thead>
                        <tr>
                            <th>Order No.</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Payment Date</th>
                            <th>Brand</th>
                            <th>Article No.</th>
                            <th>Article Description</th>
                            <th>Qty</th>
                            <th>Price Tag</th>
                            <th>Price Disc</th>
                            <th>Discount</th>
                            <th>Shipping Cost</th>
                            <th>Total Amount</th>
                            <th>Fee</th>
                            <th>Net Amount</th>
                            <th>Payment Method</th>
                            <th>Release Payment Date from Xendit</th>
                            <th>Customer Bank Name</th>
                            <th>Curr</th>
                            <th>AWB/Shipment No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sort = array();
                            $sort_number = array();
                            $tes = array();
                            foreach ($orders as $key => $value) {
                                $sort['net'][$key] = $value['net'];
                                $sort_number['order_number'][$key] = $value['order_number'];
                            }

                            array_multisort(array_column($orders, 'order_number'),  SORT_DESC, array_column($orders, 'net'), SORT_DESC, $orders);

                            $no2 = 1;
                            $array_baru = array();
                            $prev = 0;
                            $prev_shipping = 0;
                            $prev_price = 0;
                            $prev_fee = 0;
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
                        ?>
                        <tr>
                            <td><?=$value['order_number'];?></td>
                            <td><?=$value['customer_name'];?></td>
                            <td><?=$value['created_at'];?></td>
                            <td><?=$value['payment_date'];?></td>
                            <td>Colorbox</td>
                            <td><?=$value['sku'];?></td>
                            <td><?=$value['product_name'];?></td>
                            <td><?=$quantity;?></td>
                            <td><?=$value['tag_price'];?></td>
                            <td><?=$value['net'];?></td>
                            <td><?=$disc;?></td>
                            <td><?=$shipping_na;?></td>
                            <td><?=$total_amount;?></td>
                            <td><?=$xendit_fee;?></td>
                            <td><?= $value['price'] - $value['xendit_fee']?></td>
                            <td><?=$value['payment_method']?></td>
                            <td><?=$value['release_payment']?></td>
                            <td><?=$value['seller_name']?></td>
                            <td>IDR</td>
                            <td><?=$value['awb'];?></td>
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