<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th>Raffle Name</th>
					<td>:</td>
					<td><?php echo $raffle_row->raffle_name ?></td>

					<th>Total Products</th>
					<td>:</td>
					<td><?php echo sizeof($total_products_raffleid).' Products' ?></td>
				</tr>
				<tr>
					<th>Start</th>
					<td>:</td>
					<td><?php echo date('Y-m-d H:i', strtotime($raffle_row->raffle_start)) ?></td>

					<th>Total SKU</th>
					<td>:</td>
					<td><?php echo $total_sku_raffleid.' Products' ?></td>
				</tr>
				<tr>
					<th>End</th>
					<td>:</td>
					<td><?php echo date('Y-m-d H:i', strtotime($raffle_row->raffle_end)) ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>