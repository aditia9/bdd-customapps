<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Cek Resi</h2>
    </div>
    <div class="modal-body">
      
	</div>
  </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="title text-center">Order Detail</h3>
    </div>
    <?php

    if ($orderna['fulfillments'] != null){
        $no_resi = $orderna['fulfillments'][0]['tracking_number'];
        $url_resi = 'https://berdu.id/cek-resi?courier=jne&code='.$orderna['fulfillments'][0]['tracking_number'].'&secret=QJkInq';
    }else{
        $no_resi = '';
        $url_resi = '#';
    }
    ?>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="table-responsive">
                        <table class="table pertama">
                            <tr>
                                <td class="titlena">No Order</td>
                                <td>:</td>
                                <td><?php echo $orderna['name'] ?></td>
                            </tr>
                            <tr>
                                <td class="titlena">Nama</td>
                                <td>:</td>
                                <td><?php echo $orderna['customer']['first_name'].' '.$orderna['customer']['last_name'] ?></td>
                            </tr>
                            <tr>
                                <td class="titlena">Email</td>
                                <td>:</td>
                                <td><?php echo $orderna['email'] ?></td>
                            </tr>
                            <tr>
                                <td class="titlena">Alamat</td>
                                <td>:</td>
                                <td><?php echo $orderna['shipping_address']['address1'].' '.$orderna['shipping_address']['city'].' '.$orderna['shipping_address']['province'].' '.$orderna['shipping_address']['country'].' '.$orderna['shipping_address']['zip'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <?php 
                                        if($no_resi != null):
                                            if ($success == null):
                                                echo "Resi anda <b>".$no_resi."</b> tidak dapat ditemukan.";
                                            else:
                                    ?>
                                        Resi ditemukan.<br>
                                        <div class="table-responsive">
                                            <table class="table pertama">
                                                <tr>
                                                    <td class="titlena">Kurir</td>
                                                    <td class="">:</td>
                                                    <td class="">
                                                        <?=$result['result']['summary']['courier_name']?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="titlena">Status</td>
                                                    <td class="">:</td>
                                                    <td class="">
                                                        <?=$result['result']['delivery_status']['status']?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="titlena">Pengirim</td>
                                                    <td class="">:</td>
                                                    <td class="">
                                                        <?=$result['result']['summary']['shipper_name']?>, <?=$result['result']['details']['shipper_city']?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="titlena">Penerima</td>
                                                    <td class="">:</td>
                                                    <td class="">
                                                        <?=$result['result']['summary']['receiver_name']?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="titlena">Tujuan</td>
                                                    <td class="">:</td>
                                                    <td class="">
                                                        <?php
                                                            if($result['result']['details']['receiver_city'] == null):
                                                                echo $result['result']['details']['receiver_address1'];
                                                            else:
                                                                echo $result['result']['details']['receiver_city'];
                                                            endif;
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="border-0 titlena">Riwayat Pengiriman</td>
                                                    <td class="border-0">:</td>
                                                    <td class="border-0"></td>
                                                </tr>
                                                <?php
                                                    foreach ($result['result']['manifest'] as $key => $value) {
                                                ?>
                                                    <tr>
                                                        <td class="border-0 titlena"><?=$value['manifest_date'];?><br><?=$value['manifest_time'];?></td>
                                                        <td></td>
                                                        <td class="border-0"><?=$value['manifest_description'];?> <?=$value['city_name'];?></td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                            </table>
                                        </div>
                                    <?php
                                            endif;
                                        else:
                                            echo "Belum ada nomor resi";
                                        endif;
                                    ?>
                                </td>
                                <td></td>
                                <td>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hovered kedua">
                            <thead>
                                <td class="titlena">Produk</td>
                                <td class="titlena">Qty</td>
                                <td class="titlena">Harga</td>
                            </thead>
                            <tbody>
                                <?php foreach ($orderna['line_items'] as $key => $value) {?>
                                <tr>
                                <td class="titlena"><?php echo $value['title'].' - '.$value['variant_title'] ?></td>    
                                <td><?php echo $value['quantity'] ?></td>    
                                <td class=""><?php echo number_format($value['price'],2) ?></td>    
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="">
                                    <td colspan="2" class="titlena text-right">Tax</td>
                                    <td class=""><?php echo number_format($orderna['total_tax'],2) ?></td>
                                </tr>
                                <tr class="">
                                    <?php
                                        if($orderna['shipping_lines'] != null){
                                    ?>
                                    <td colspan="2" class="titlena text-right">Shipping (<?php echo $orderna['shipping_lines'][0]['title'] ?>)</td>
                                    <td><?php echo number_format($orderna['shipping_lines'][0]['price'],2) ?></td>
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <td>Shipping ()</td>
                                        <td></td>
                                    <?php
                                        }
                                    ?>
                                </tr>
                                <tr class="">
                                    <td colspan="2" class="titlena text-right">Discount</td>
                                    <td><?php echo number_format($orderna['total_discounts'],2) ?></td>
                                </tr>
                                <tr class="">
                                    <td colspan="2" class="titlena text-right">Total</td>
                                    <td class="titlena"><?php echo number_format($orderna['total_price'],2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="title text-center">Order Tracking</h3>
    </div>
    <?php
    if ($orderna['financial_status'] == 'pending' && $orderna['fulfillment_status'] == null && $orderna['cancel_reason'] == null) {
        $status_pay = '';
        $fulfil_status = '';
        $cancel = 'no-cancel';
        $show_cancel = 'hide-cancel';
        $show_kirim = 'show_kirim';
    }elseif ($orderna['financial_status'] == 'paid' && $orderna['fulfillment_status'] == null) {
        $status_pay = 'wizstatedone';
        $fulfil_status = '';
        $cancel = 'no-cancel';
        $show_cancel = 'hide-cancel';
        $show_kirim = 'show_kirim';
    }elseif ($orderna['financial_status'] == 'pending' && $orderna['fulfillment_status'] == null && $orderna['cancel_reason'] != null) {
        $status_pay = '';
        $fulfil_status = '';
        $cancel = 'canceled';
        $show_cancel = 'show_cancel';
        $show_kirim = 'hide-kirim';
    }
    else{
        $status_pay = 'wizstatedone';
        $fulfil_status = 'wizstatedone';
        $cancel = 'no-cancel';
        $show_cancel = 'hide-cancel';
        $show_kirim = 'show_kirim';
    }
    ?>
    <div class="card-body">
        <div class="container">
            <div class="row wizcontainer-fluid">
                <div class="col-sm-3 wizcols startstatus clearfix">
                    <div class="wizstatebase center-block wizstatedone">
                        <span><i class="fa fa-check"></i></span>
                    </div>
                    <h4>Order Diterima</h4>
                </div>
                <div class="col-sm-3 wizcols startstatus clearfix">
                    <div class="wizstatebase center-block <?php echo $status_pay.' '.$cancel ?>">
                        <span><i class="fa fa-check"></i></span>
                    </div>
                    <h4>Pembayaran Diterima</h4>
                </div>
                <div class="col-sm-3 wizcols clearfix">
                    <div class="wizstatebase center-block <?php echo $fulfil_status.' '.$cancel ?>">
                        <span><i class="fa fa-check"></i></span>
                        <img src="images/icn-out-for-delivery.svg" alt="" />
                    </div>
                    <h4>Order Diproses</h4>
                </div>
                <div class="col-sm-3 wizcols clearfix <?php echo $show_kirim ?>">
                    <div class="wizstatebase last center-block <?php echo $fulfil_status.' '.$cancel ?>">
                        <span><i class="fa fa-check"></i></span>
                        <img src="images/icn-delivered.svg" alt="" />
                    </div>
                    <h4>Order Dikirim</h4>
                    
                </div>
                <div class="col-sm-3 wizcols clearfix <?php echo $show_cancel ?>">
                    <div class="wizstatebase-cancel last center-block">
                        <span><i class="fa fa-check"></i></span>
                        <img src="images/icn-delivered.svg" alt="" />
                    </div>
                    <h4>Order Dicancel</h4>
                </div>
            </div>
        </div>
    </div>
</div>