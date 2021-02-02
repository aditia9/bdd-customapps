<html>
	<head>
	    <title>Tracking Order</title>
	    <?php $this->load->view('css-js/css'); ?>
	</head>
	<body>
	    <nav class="navbar navbar-expand-lg bg-primary">
	        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
	            <p class="text-white m-0 p-2">Track Order</p>
	        </div>
	    </nav>

	    <div class="row pt-3 m-0">
	    	<div class="col-md-12 col-12" id="append-error"></div>
	    	<div class="col-md-8 col-12">
	    		<div class="card">
	            	<div class="card-header">
	            		<h4 class="m-0 font-weight-bold">Update Resi</h4>
	            	</div>
	            	<div class="card-body">
	            		<div class="responsive">
	            			<!-- <form action="<?=site_url('config/upd_resi');?>" method="post" name="upd_resi" id="upd_resi"> -->
				    			<table class="table">
				    				<tr>
				    					<th>No Order</th>
				    					<!-- <th>Nama</th> -->
				    					<th>Email</th>
				    					<!-- <th>Alamat</th> -->
				    					<th>No Resi	</th>
				    				</tr>
				    				<?php
						                foreach ($orders as $key => $value) {
						            ?>
				    					<tr>
							            	<td><?=$value['order_number'];?></td>
							            	<!-- <td><?=$value['order_billing_name'];?></td> -->
							            	<td><?=$value['order_email'];?></td>
							            	<!-- <td><?=$value['order_address'];?></td> -->
							            	<td>
							            		<input type="hidden" name="order_id" value="<?=$value['order_id'];?>">
			                                    <input type="hidden" name="fulfill_id" value="<?=$value['order_resi_id'];?>">
			            						<input type="hidden" name="shop" value="<?=$shop->url_shopify;?>">
			            						<input type="text" name="no_resi" class="form-control" value="<?=$value['order_resi'];?>" id="no_resi">
							            	</td>
				    					</tr>
				    				<?php
						                }
						            ?>
				    			</table>
				    			<div class="submit-resi text-right">
				    				<input type="submit" name="upd_resi" value="Submit" class="btn btn-info" id="submit_resi">
				    			</div>
			    			<!-- </form> -->
			    		</div>	
	            	</div>
	            </div>
	    	</div>
	    	
	    	<div class="col-md-4 col-12">
	    		<div class="row m-0">
			        <div class="col-md-12 col-12">
			            <div class="card">
			            	<div class="card-header">
			            		<h4 class="m-0 font-weight-bold">Order Selected</h4>
			            	</div>

	                        <?php if($selected != ''): ?>
			                <div class="card-body">
	                            <?=$selected;?>
			                </div>
	                        <?php endif; ?>

			                <?php if($pending != ''): ?>
			                <div class="card-footer">
			                	Pesanan dengan nomor order :
								<span class="text-warning">
									<br><?=$pending;?>
								</span>
								belum di proses / status masih <span class="text-warning">unfulfilled</span>.
			                </div>
			            	<?php endif; ?>

			    			<div class="card-footer">
			                	Jika order yang dipilih tidak muncul artinya order tersebut telah <span class='text-danger'>melebihi 60 hari</span>
			                </div>

			            </div>
			        </div>
			    </div>
	    	</div>

	    </div>
	    
	    <div class="bottom bg-primary">
	        <div class="container p-4" id="contact">
	            <div class="contact text-white text-center">
	                <b>Need help? Don't hestitate to <a data-toggle="modal" data-target="#contact-footer" class="text-danger modalna">Contact Us</a>
	                </b>
	            </div>
	            <div class="modal fade" style="color: #000 !important; text-align: left !important;" id="contact-footer" tabindex="-1" role="dialog" aria-hidden="true">
	                <div class="modal-dialog" role="document">
	                    <div class="modal-content">
	                        <div class="modal-header no-bd">
	                            <h3 class="modal-title">Contact</h3>
	                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                            <span aria-hidden="true">×</span>
	                            </button>
	                        </div>

	                        <form action="<?=site_url('controller_all/send_contact_mail');?>" method="post" id="contact-mail">
	                        <div class="modal-body">
	                            <input type="hidden" name="url_shopify" value="<?=$shop->url_shopify;?>">
	                            <input type="hidden" name="app_idna" value="<?=$shop->id_merchant;?>">
	                            <div class="form-group">
	                                <label class="control-label">Email (We will reply your messages to this email)</label>
	                                <input type="text" name="email_merchant" class="form-control" value="<?=$shop->email_merchant;?>" placeholder="Your email">
	                            </div>

	                            <div class="form-group">
	                                <label class="control-label">Name</label>
	                                <input type="text" name="name" class="form-control" placeholder="Your name">
	                            </div>

	                            <div class="form-group">
	                                <label class="control-label">Subject</label>
	                                <input type="text" name="subjectna" class="form-control" placeholder="Your subject message">
	                            </div>
	                            <div class="form-group">
	                                <label class="control-label">Message</label>
	                                <textarea class="form-control" name="messagesna"></textarea>
	                            </div>
	                        </div>
	                        <div class="modal-footer">
	                                
	                                <button type="submit" class="btn btn-secondary btn-sm">Send Request</button>
	                        </div>
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

	    <?php $this->load->view('css-js/js'); ?>
	    <script>
	    	$('#submit_resi').click(function(){
	    		var order_id = [];
	    		var fulfill_id = [];
	    		var no_resi = [];
		        $('input[name=order_id]').each(function(){
		            order_id.push($(this).val());
		        });
		        $('input[name=fulfill_id]').each(function(){
		            fulfill_id.push($(this).val());
		        });
		        $('input[name=no_resi]').each(function(){
		            no_resi.push($(this).val());
		        });
		       
	    		var url_shopify = $('input[name=shop]').val();
	    		console.log(order_id);

		        $.ajax({
		            url : "<?=site_url('config/upd_resi');?>",
		            method : "POST",
		            data : {order_id:order_id, fulfill_id:fulfill_id, no_resi:no_resi, url_shopify:url_shopify},
		            success : function(data){
		                location.reload();
		            },
		            error: function (e) {
		                console.log(e);
		            }
		        });

	    	});
	    </script>
	</body>
</html>