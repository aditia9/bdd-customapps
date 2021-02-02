<div class="container">
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hovered table-bordered basic-datatables">
						<thead>
							<th>#</th>
							<th>Destination</th>
							<th>City</th>
							<th>Subdistrict</th>
							<th>Tarif</th>
						</thead>
						<tbody>
							<?php $no=1;foreach ($ongkir as $key => $value) {?>
							<tr>
								<td><?php echo $no++ ?></td>
								<td><?php echo $value['destination_code'] ?></td>
								<td><?php echo $value['city'] ?></td>
								<td><?php echo $value['subdistrict'] ?></td>
								<td><?php echo $value['tarif'] ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
