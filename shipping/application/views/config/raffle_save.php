<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th>Raffle Name</th>
							<td>:</td>
							<td><?php echo $raflle_name ?></td>

							<th>Date</th>
							<td>:</td>
							<td><?php echo $raflle_date ?></td>
						</tr>
						<tr>
							<th>Total Participants</th>
							<td>:</td>
							<td><?php echo $participants.' Orders' ?>
							</td>

							<th>Total Products</th>
							<td>:</td>
							<td><?php echo $product_raffle ?> Products
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<th>Products</th>
							<th>Participants</th>
							<th>Actions</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<img src="<?php echo base_url().'assets/upload/nike.jpg' ?>" class="img-fluid" style="max-width: 120px;"/><br>
									<strong>Nike Airmax 95 - Size 41</strong>
								</td>
								<td><?php echo number_format($participants / $product_raffle) ?> Orders</td>
								<td><a href="#" class="btn btn-sm btn-primary">Find Winner</a></td>
							</tr>
							<tr>
								<td>
									<img src="<?php echo base_url().'assets/upload/nike.jpg' ?>" class="img-fluid" style="max-width: 120px;"/><br>
									<strong>Nike Airmax 95 - Size 42</strong>
								</td>
								<td><?php echo number_format(number_format($participants / $product_raffle)) ?> Orders</td>
								<td><a href="#" class="btn btn-sm btn-primary">Find Winner</a></td>
							</tr>
							<tr>
								<td>
									<img src="<?php echo base_url().'assets/upload/nike.jpg' ?>" class="img-fluid" style="max-width: 120px;"/><br>
									<strong>Nike Airmax 95 - Size 43</strong>
								</td>
								<td><?php echo number_format($participants / $product_raffle) ?> Orders</td>
								<td><a href="#" class="btn btn-sm btn-primary">Find Winner</a></td>
							</tr>
							<tr>
								<td>
									<img src="<?php echo base_url().'assets/upload/nike2.jpg' ?>" class="img-fluid" style="max-width: 120px;"/><br>
									<strong>Nike Airmax 90 - Size 41</strong>
								</td>
								<td><?php echo number_format($participants / $product_raffle) ?> Orders</td>
								<td><a href="#" class="btn btn-sm btn-primary">Find Winner</a></td>
							</tr>
							<tr>
								<td>
									<img src="<?php echo base_url().'assets/upload/nike2.jpg' ?>" class="img-fluid" style="max-width: 120px;"/><br>
									<strong>Nike Airmax 90 - Size 42</strong>
								</td>
								<td><?php echo number_format($participants / $product_raffle) ?> Orders</td>
								<td><a href="#" class="btn btn-sm btn-primary">Find Winner</a></td>
							</tr>
							<tr>
								<td>
									<img src="<?php echo base_url().'assets/upload/nike2.jpg' ?>" class="img-fluid" style="max-width: 120px;" /> <br>
									<strong>Nike Airmax 90 - Size 43</strong>
								</td>
								<td><?php echo number_format($participants / $product_raffle) ?> Orders</td>
								<td><a href="#" class="btn btn-sm btn-primary">Find Winner</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>