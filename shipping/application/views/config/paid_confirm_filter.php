<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<p>Please choose to complete the installation of this app to the theme you are using.</p>
				<div class="filter">
					<form class="form" method="post" action="<?php echo base_url().'config/filter_list' ?>" id="filter_list">
						<input type="hidden" name="id_merchant" value="<?php echo $id_merchant ?>">
						<div class="form-group">
							<label class="control-label">
								From Date
							</label>
							<input type="text" name="from_date" class="form-control dpicker" value="<?php echo $from_date ?>" />
						</div>
						<div class="form-group">
							<label class="control-label">
								To Date
							</label>
							<input type="text" name="to_date" class="form-control dpicker" value="<?php echo $to_date ?>" />
						</div>

						<div class="form-group">
		                    <button class="btn btn-primary" type="submit">Kirim</button>
		                </div>
					</form>
				</div>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table" id="all_list_pc">
						<thead>
							<th>No</th>
							<th>ID Order</th>
							<th>Email</th>
							<th>Pay to</th>
							<th>Image Proof</th>
							<th>Date</th>
							<th>Note</th>
						</thead>
						<tbody>
							<?php $no = 1; foreach ($all_confirm_paid as $key => $value) {?>
							<tr>
								<td><?php echo $no++ ?></td>
								<td><?php echo $value['no_order'] ?></td>
								<td><?php echo $value['email'] ?></td>
								<td><?php echo $value['bayar_ke'] ?></td>
								<td>
									<a href="<?php echo base_url().'image-proof/'.$value['bukti_tf'] ?>" target="_blank">
										<img src="<?php echo base_url().'image-proof/'.$value['bukti_tf'] ?>" width="150px" />
									</a>
								</td>
								<td><?php echo date('d-m-Y', strtotime($value['tgl_transfer'])) ?></td>
								<td><?php echo $value['catatan'] ?></td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>