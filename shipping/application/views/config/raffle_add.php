<div class="container">
	<div class="page-inner">
		<div class="row">

			<form action="<?php echo base_url().'config/raffle_save' ?>" method="post">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th>Raffle Name</th>
							<td>:</td>
							<td>
								<div class="form-group">
									<input type="text" name="raffle_name" class="form-control" />
								</div>
							</td>

							<th>Total Products</th>
							<td>:</td>
							<td><?php echo sizeof($products).' Products' ?>
								<input type="hidden" name="participants" value="<?php echo sizeof($participants) ?>" />
							</td>
						</tr>
						<tr>
							<th>Start</th>
							<td>:</td>
							<td>
								<div class="form-group">
									<input type="text" name="raffle_start" class="form-control dpicker" />
								</div>
							</td>

							<th>Total Quantity</th>
							<td>:</td>
							<td><?php echo $total_qty.' Products' ?>
								<input type="hidden" name="participants" value="<?php echo sizeof($total_qty) ?>" />
							</td>
						</tr>
						<tr>
							<th>End</th>
							<td>:</td>
							<td>
								<div class="form-group">
									<input type="text" name="raffle_end" class="form-control dpicker" />
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table">
						<?php $no=1;foreach ($products as $key => $value) {?>
						<tr>
							<th><?php echo $no++ ?></th>
							<th>
								<p><?php echo $value['product_name'] ?></p>
								<p>Qty: <?php echo $value['qty'] ?></p>
							</th>
							<th><img src="<?php echo $value['image_src'] ?>" style="max-width: 120px;" /></th>
							<th>
								<input type="hidden" name="id_product[]" value="<?php echo $value['id_product'] ?>" />
								<input type="hidden" name="product_name[]" value="<?php echo $value['product_name'] ?>" />
								<input type="hidden" name="id_variant[]" value="<?php echo $value['id_variant'] ?>" />
								<div class="form-group">
									<label class="control-label">Ticket Points</label>
									<input type="text" name="spending_for_ticket[]" class="form-control" />
								</div>
							</th>
							<th>
								<div class="form-group">
									<label class="control-label">Max Participants</label>
									<input type="text" name="max_participants[]" class="form-control" />
								</div>
							</th>
						</tr>
						<?php } ?>

						<tr>
							<td colspan="2">
								<button type="submit" class="btn btn-primary">Save and Next</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>