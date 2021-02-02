<div class="pt-4 pb-5">
	<div class="container py-2">
		<div class="align-items-center">
			<div class="text-center">
				<h1 class="mb-3">Payment Confirmation</h1>
				<h5 class="op-7 mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h5>
			</div>

			
		</div>
	</div>
</div>
	<div class="container">
        <div class="content">
            <div class="card">
            	<form class="form" method="post" action="<?php echo base_url().'front/bukti_tf' ?>" enctype="multipart/form-data" id="submit_form_ac">
	                <div class="form-group">
	                    <label class="control-label">No Order</label>
	                    <input type="text" name="no_order" class="form-control" placeholder="1001" />
	                </div>
	                <div class="form-group">
	                    <label class="control-label">Email</label>
	                    <input type="text" name="email" class="form-control" placeholder="your email address" />
	                </div>
	                <div class="form-group">
	                    <label class="control-label">Tanggal Transfer</label>
	                    <input type="text" name="tgl_tf" class="form-control dpicker" />
	                </div>
	                <div class="form-group">
	                    <label class="control-label">Bayar Ke</label>
	                    <select class="form-control" name="bayar_ke">
	                    	<option value="bca">BCA</option>
	                    	<option value="mandiri">Mandiri</option>
	                    </select>
	                </div>
	                <div class="form-group">
	                    <label class="control-label">Bukti Transfer</label>
	                    <input type="file" name="bukti_tf" class="form-control" />
	                </div>
	                <div class="form-group">
	                    <label class="control-label">Catatan</label>
	                    <input type="text" name="catatan" class="form-control" />
	                </div>

	                <div class="form-group">
	                    <button class="btn btn-primary" type="submit">Kirim</button>
	                </div>
	            </form>
            </div>
    	</div>
	</div>

	
