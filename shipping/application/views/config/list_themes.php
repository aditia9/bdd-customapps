<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-8 m-auto">
				<div class="card">
					<input type="hidden" name="url_shopify" id="url_shopify" value="<?php echo $url_shopify ?>">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<th>No</th>
								<th>ID</th>
								<th>Template Name</th>
								<th>#</th>
							</thead>
							<tbody>
								<?php 
								// var_dump($produkna);
								// die();
								$no=1; foreach ($themesna as $key => $value) {?>
								<input type="hidden" name="id_themes[]" id="id_themes_<?php echo $key ?>" value="<?php echo $value['id'] ?>">
								<tr>
									<td><?php echo $no++ ?></td>
									<td><?php echo $value['id'] ?></td>
									<td><?php echo $value['name'] ?></td>
									<td>
									<?php
									if ($value['role'] == 'main') {
									?>
										<a href="#" class="btn btn-sm btn-primary" onclick="instal_themes(<?php echo $key ?>)">Published</a>
									<?php
									}else{
									?>
										<a href="#" class="btn btn-sm btn-danger">Unpublished</a>
									<?php
									}
									?>
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
</div>

<script type="text/javascript">
	function instal_themes(e){
        var urlna_ = "<?=base_url().'config/install_themes' ?>";
		
		var datana = {
            id_themes: $('#id_themes_' + e).val(),
            url_shopify: $('#url_shopify').val(),
        };
		$.ajax({
            type: "POST",
            url: urlna_,
            data: datana,
            success: function(result) {
                swal({title: "Success", text: "Generate Success", type: "success"}
                        
                );
            }
        });
	}
</script>