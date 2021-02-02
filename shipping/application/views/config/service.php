<?php
$list_service = explode(',', $merchant_row->servicena);

$reg = '';
$reg_asuransi = '';

foreach ($list_service as $key => $value) {
	if ($value == 'reg') {
		$reg = 'checked';
	}
	elseif ($value == 'reg_asuransi') {
		$reg_asuransi = 'checked';
	}
}
?>
<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-10 m-auto">
				<div class="card">
					<div class="card-header">
						<h3>Service List</h3>
					</div>
					<table class="table">
						<tr>
							<th>REG</th>
							<td>:</td>
							<th>
								<label class="switch">
								  	<input type="checkbox" id="reg" onchange="reg()" <?php echo $reg ?> >
								  	<span class="slider round"></span>
								</label>
							</th>
						</tr>
						<tr>
							<th>REG with Insurance</th>
							<td>:</td>
							<th>
								<label class="switch">
								  	<input type="checkbox" id="reg_asuransi" onchange="reg_asuransi()" <?php echo $reg_asuransi ?> >
								  	<span class="slider round"></span>
								</label>
							</th>
						</tr>
					</table>
				</div>

				<div class="card">
					<div class="card-header">
						<h3>Set Free Shipping (REG only)</h3>
					</div>
					<form action="<?php echo base_url().'config/subsidi_ongkir' ?>" method="post">
						<input type="hidden" name="url_shopify" value="<?php echo $merchant_row->id_merchant ?>" id="url_shopify">
						<div class="form-group">
							<label class="control-label">Max. Shipping Rate</label>
							<input type="text" name="subsidi_ongkir" class="form-control" value="<?php echo $merchant_row->subsidi_ongkir ?>" />
						</div>
						<div class="form-group">
							<label class="control-label">Min. Order</label>
							<input type="text" name="minimum_order" class="form-control" value="<?php echo $merchant_row->minimum_order ?>"/>
						</div>
						<div class="form-group">
							<button class="btn btn-info btn-sm" type="submit">Save</button>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	function reg(){
        var mode= $('#reg').prop('checked');
        var urlna_ = "<?=base_url().'config/reg' ?>";
        var datana = {
            url_shopify: $('#url_shopify').val(),
            mode: mode
        };
        $.ajax({
            type: "POST",
            url: urlna_,
            data: datana,
            beforeSend: function() {
		        $('#load-before-send').removeClass('hide');
		    },
            success: function(result) {
                swal({title: "Success", text: result , type: "success", icon: "success"}).then(function(){ 
                	$('#load-before-send').addClass('hide');
		   			location.reload();
		   		});
            }
        });
	}

	function reg_asuransi(){
        var mode= $('#reg_asuransi').prop('checked');
        var urlna_ = "<?=base_url().'config/reg_asuransi' ?>";
        var datana = {
            url_shopify: $('#url_shopify').val(),
            mode: mode
        };
        $.ajax({
            type: "POST",
            url: urlna_,
            data: datana,
            beforeSend: function() {
		        $('#load-before-send').removeClass('hide');
		    },
            success: function(result) {
                swal({title: "Success", text: result , type: "success", icon: "success"}).then(function(){ 
                	$('#load-before-send').addClass('hide');
		   			location.reload();
		   		});
            }
        });
	}

	function yes(){
        var mode= $('#yes').prop('checked');
        var urlna_ = "<?=base_url().'config/yes' ?>";
        var datana = {
            url_shopify: $('#url_shopify').val(),
            mode: mode
        };
        $.ajax({
            type: "POST",
            url: urlna_,
            data: datana,
            beforeSend: function() {
		        $('#load-before-send').removeClass('hide');
		    },
            success: function(result) {
                swal({title: "Success", text: result , type: "success", icon: "success"}).then(function(){ 
                	$('#load-before-send').addClass('hide');
		   			location.reload();
		   		});
            }
        });
	}

	// function yes_asuransi(){
 //        var mode= $('#yes_asuransi').prop('checked');
 //        var urlna_ = "<?=base_url().'config/yes_asuransi' ?>";
 //        var datana = {
 //            url_shopify: $('#url_shopify').val(),
 //            mode: mode
 //        };
 //        $.ajax({
 //            type: "POST",
 //            url: urlna_,
 //            data: datana,
 //            beforeSend: function() {
	// 	        $('#load-before-send').removeClass('hide');
	// 	    },
 //            success: function(result) {
 //                swal({title: "Success", text: result , type: "success", icon: "success"}).then(function(){ 
 //                	$('#load-before-send').addClass('hide');
	// 	   			location.reload();
	// 	   		});
 //            }
 //        });
	// }
	

	function sps(){
        var mode= $('#sps').prop('checked');
        var urlna_ = "<?=base_url().'config/sps' ?>";
        var datana = {
            url_shopify: $('#url_shopify').val(),
            mode: mode
        };
        $.ajax({
            type: "POST",
            url: urlna_,
            data: datana,
            beforeSend: function() {
		        $('#load-before-send').removeClass('hide');
		    },
            success: function(result) {
                swal({title: "Success", text: result , type: "success", icon: "success"}).then(function(){ 
                	$('#load-before-send').addClass('hide');
		   			location.reload();
		   		});
            }
        });
	}

	// function sps_asuransi(){
 //        var mode= $('#sps_asuransi').prop('checked');
 //        var urlna_ = "<?=base_url().'config/sps_asuransi' ?>";
 //        var datana = {
 //            url_shopify: $('#url_shopify').val(),
 //            mode: mode
 //        };
 //        $.ajax({
 //            type: "POST",
 //            url: urlna_,
 //            data: datana,
 //            beforeSend: function() {
	// 	        $('#load-before-send').removeClass('hide');
	// 	    },
 //            success: function(result) {
 //                swal({title: "Success", text: result , type: "success", icon: "success"}).then(function(){ 
 //                	$('#load-before-send').addClass('hide');
	// 	   			location.reload();
	// 	   		});
 //            }
 //        });
	// }

</script>