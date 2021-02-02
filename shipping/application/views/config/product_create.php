<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>First Step</h2>
				<?php
				if ($type_cart == 'drawer') {
				?>
				
				<span class="sec-note">
					Your themes have cart with type 'Drawer', please change to type 'Page'. Online Store > Themes > Customize > Theme Settings > Cart page.
				</span>
				<?php
				}
				?>
			</div>
			<div class="col-md-12">
				<p>Please choose to complete the installation of this app to the theme you are using.</p>
			</div>
			
			<div class="col-md-4 m-auto">
				<div class="card">
					<div class="card-header">
						<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#request-modal"><h3>Request Installation</h3>
						</button>
					</div>
				</div>
			</div>
			<div class="col-md-4 m-auto">
				<div class="card">
					<div class="card-header">
						<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#auto-modal">
							<h3>Automatic Installation</h3>
						</button>
					</div>
				</div>
			</div>
			<div class="col-md-4 m-auto">
				<div class="card">
					<div class="card-header">
						<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#manual-modal">
							<h3>Manual Installation</h3>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 m-auto">
				<!-- Modal -->
                <div class="modal fade" id="request-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header no-bd">
                                <h3 class="modal-title">Request Installation</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                For the installation will be done by our team. After clicking request button we will request to collaborate your store. Learn how about collaborator account <a href="https://help.shopify.com/en/manual/your-account/staff-accounts/collaborator-accounts" target="_blank">here</a>.
                                
                            </div>
                            <div class="modal-footer">
                            	<form action="<?php echo base_url()?>config/send_request_mail" method="post" id="request_install">
                                	<input type="hidden" name="url_shopify" value="<?php echo $merchant_row->url_shopify ?>">
                                	<input type="hidden" name="email_merchant" value="<?php echo $merchant_row->email_merchant ?>">
                                	<button type="submit" class="btn btn-success btn-sm">Send Request</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal -->

                <div class="modal fade" id="manual-modal" tabindex="-1" role="dialog" aria-hidden="true">
                	<div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header no-bd">
                                <h3 class="modal-title">Manual Installation</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                            	<h4>Please follow this instruction to find your product handle.</h4>
                            	<a href="https://bdd.services/kodeunik-apps/front/help" target="_blank">See Documentation</a>
                            	<form action="<?php echo base_url().'config/add_product_handle' ?>" method="post" id="manual-form">
                            		<div class="form-group">
                            			<label class="control-label">Product Handle</label>
                            			<input type="text" name="product_handle" class="form-control" />
                                		<input type="hidden" name="url_shopify" value="<?php echo $merchant_row->url_shopify ?>">
                            		</div>

                            		<div class="form-actions">
                            			<button class="btn btn-info btn-sm" type="submit">Save</button>
                            		</div>
                            	</form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="auto-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header no-bd">
                                <h3 class="modal-title">Automatic Installation</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
									<input type="hidden" name="url_shopify" id="url_shopify" value="<?php echo $merchant_row->url_shopify ?>">
									<table class="table">
										<thead>
											<th>No</th>
											<th>Template Name</th>
											<th>Automatic App Installation</th>
										</thead>
										<tbody>
											<?php 
											
											$no=1; foreach ($all_themes as $key => $value) {?>
											<input type="hidden" name="id_themes[]" id="id_themes_<?php echo $key ?>" value="<?php echo $value['id'] ?>">
											<tr>
												<td><?php echo $no++ ?></td>
												<td>
												<?php 
												if ($value['role'] == 'main') {
													echo '<b>'.$value['name'].' (Published)</b>'; 
												}else{
													echo $value['name'];
												}
												?>
												</td>
												<td>
												<?php
												if ($value['role'] == 'main') {
												?>
													<a href="#" class="btn btn-sm btn-primary" onclick="instal_themes(<?php echo $key ?>)">Install here</a>
												<?php
												} ?>
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
                <!-- end modal -->
				<!-- <div class="card">
					<div class="card-header">
						<h4>List Themes</h4>
					</div>
					
					<div class="container page-inner">
					
						<div class="form-text text-muted text-center">Click button bellow to create new unique code transactions.</div>
						<form action="<?php echo base_url().'otomatisasi/product_add/' ?>" method="post" class="text-center">
							<input type="hidden" name="url_shopify" value="<?php echo $merchant_row->url_shopify ?>">
							<button class="btn btn-sm btn-primary">Create Code</button>
						</form>
					</div>
				</div> -->
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function instal_themes(key){
        var urlna_ = "<?=base_url().'otomatisasi/product_add' ?>";
        var datana = {
            id_themes: $('#id_themes_' + key).val(),
            url_shopify: $('#url_shopify').val(),
        };

        $.ajax({
            type: "POST",
            url: urlna_,
            data: datana,
            beforeSend: function() {
		        $('#load-before-send').removeClass('hide');
		        $('#auto-modal').modal('hide');
		    },
            success: function(result) {
                swal({title: "Success", text: "App Installed on this theme!" ,icon: "success", type: "success"}).then(function(){ 
                	$('#load-before-send').addClass('hide');
		   			location.reload();
		   		});
            }
        });
    }
</script>
