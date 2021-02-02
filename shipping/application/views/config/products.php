<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-8 m-auto">
				<div class="card">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<th>No</th>
								<th>ID</th>
								<th>Product</th>
							</thead>
							<tbody>
								<?php 
								// var_dump($produkna);
								// die();
								$no=1; foreach ($produkna as $key => $value) {?>
								<tr>
									<td><?php echo $no++ ?></td>
									<td><?php echo $value['id'] ?></td>
									<td><?php echo $value['title'] ?></td>
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