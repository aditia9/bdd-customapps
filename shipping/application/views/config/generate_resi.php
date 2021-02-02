<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-10 m-auto">
				<div class="card">
					<div class="card-header">
						<h3>Resi (JNE)</h3>
					</div>
					<div class="card-body">
	            		<div class="responsive">
			    			<table class="table">
			    				<tr>
			    					<th>No.</th>
			    					<th>No Order</th>
			    					<th>Respon</th>
			    					<th>No Resi</th>
			    				</tr>
			    				<?php
			    					$no = 1;
					                foreach ($response as $key => $value) {
					            ?>
			    					<tr>
			    						<td><?=$no++;?>.</td>
						            	<td><?=$value['order_number'];?></td>
				    					<td><?=$value['response'];?></td>
				    					<td><?=$value['resi'];?></td>
			    					</tr>
			    				<?php
					                }
					            ?>
			    			</table>
			    		</div>

			    		<div id="response" class="mt-4">

			    		</div>

	            	</div>
				</div>

			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
	// $('#response').html(url);

	$('#submit_resi').click(function(){
		var order_id = [];
		var order_number = [];
		var receiver_name = [];
		var address1 = [];
		var address2 = [];
		var city = [];
		var zip = [];
		var phone = [];
		var qty = [];
		var weight = [];
		var lokasi = [];
		var goodsdesc = [];
		var goodsvalue = [];
		var goodstype = [];
		var ins_flag = [];
		var origin = [];
		var destination = [];
		var service = [];
		var cod_flag = [];
		var cod_amount = [];

		$('input[name=order_id]').each(function(){
            order_id.push($(this).val());
        });

        $('input[name=order_number]').each(function(){
            order_number.push($(this).val());
        });

        $('input[name=receiver_name]').each(function(){
            receiver_name.push($(this).val());
        });

        $('input[name=address1]').each(function(){
            address1.push($(this).val());
        });

        $('input[name=address2]').each(function(){
            address2.push($(this).val());
        });

        $('input[name=city]').each(function(){
            city.push($(this).val());
        });

        $('input[name=zip]').each(function(){
            zip.push($(this).val());
        });

        $('input[name=phone]').each(function(){
            phone.push($(this).val());
        });

        $('input[name=qty]').each(function(){
            qty.push($(this).val());
        });

        $('input[name=weight]').each(function(){
            weight.push($(this).val());
        });

        $('input[name=goodsdesc]').each(function(){
            goodsdesc.push($(this).val());
        });

        $('input[name=goodsvalue]').each(function(){
            goodsvalue.push($(this).val());
        });

        $('input[name=goodstype]').each(function(){
            goodstype.push($(this).val());
        });

        $('input[name=ins_flag]').each(function(){
            ins_flag.push($(this).val());
        });

        $('input[name=origin]').each(function(){
            origin.push($(this).val());
        });

        $('input[name=destination]').each(function(){
            destination.push($(this).val());
        });

        $('input[name=service]').each(function(){
            service.push($(this).val());
        });

        $('input[name=cod_flag]').each(function(){
            cod_flag.push($(this).val());
        });

        $('input[name=cod_amount]').each(function(){
            cod_amount.push($(this).val());
        });



        var url_shopify = $('input[name=shop]').val();

		$.ajax({
            url : "<?=site_url('config/generate_resi');?>",
            method : "POST",
            data : {order_id:order_id, url_shopify:url_shopify, order_number:order_number, receiver_name:receiver_name, address1:address1, address2:address2, city:city, zip:zip, phone:phone, qty:qty, weight:weight, goodsdesc:goodsdesc, goodsvalue:goodsvalue, goodstype:goodstype, ins_flag:ins_flag, origin:origin, destination:destination, service:service, cod_flag:cod_flag, cod_amount},
            beforeSend: function() {
                $(".selesai-loader").show();
            },
            success : function(data){
            	$(".selesai-loader").hide();
				console.log(data)
				// alert(data)
				// location.reload();
				$('#response').html(data);
            },
            error: function (e) {
                console.log(e);
            }
        });

	});
</script>