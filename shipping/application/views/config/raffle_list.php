<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<p>Recent Raffle.</p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<th>#</th>
							<th>Title</th>
							<th>Start</th>
							<th>End</th>
							<th>Total Products Raffle</th>
							<th>Actions</th>
						</thead>
						<tbody>
							<?php $no=1; foreach ($raffle_list as $key => $value) { ?>
							<tr>
								<td><?php echo $no++ ?></td>
								<td><?php echo $value['raffle_name'] ?></td>
								<td><?php echo date('Y-m-d H:i', strtotime($value['raffle_start'])) ?></td>
								<td><?php echo date('Y-m-d H:i', strtotime($value['raffle_end'])) ?></td>
								<td><?php echo sizeof($this->Data_master_m->total_products_raffleid($value['id'])) ?></td>
								<td>
									<a href="<?php echo base_url().'config/raffle_detail/'.$value['id'] ?>" class="btn btn-sm btn-info">Detail</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function ac_active_(){
        var mode= $('#ac_active').prop('checked');
        var urlna_ = "<?=base_url().'config/ac_active' ?>";
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

	function pn_active_(){
        var mode= $('#notif_paid').prop('checked');
        var urlna_ = "<?=base_url().'config/pn_active' ?>";
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

	function save_waktu(){
        var waktu= $('#waktu').val();
        var urlna_ = "<?=base_url().'config/save_waktu' ?>";
        var datana = {
            url_shopify: $('#url_shopify').val(),
            waktu: waktu
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
</script>