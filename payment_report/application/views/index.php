<html>
	<head>
		<title>Track Order</title>
		<?php require_once('css-js/table-css-js.php'); ?>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-primary header-app">
		  	<a class="navbar-brand text-white">Track Order</a>
		</nav>
		<div class="container mt-5">
			<div class="alert alert-primary w-50 mx-auto" role="alert">
			  A simple form for installing apps!
			</div>

			<form action="<?=site_url('front/install');?>" method="post" class="w-50 mx-auto">
				<label for="basic-url">Your store URL</label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon3">https://</span>
					</div>
					<input type="text" class="form-control p-4" name="urlna" placeholder="yourstore.myshopify.com">
				</div>
				<div class="input-group justify-content-center">
					<button type="submit" class="btn btn-primary w-50 text-center p-2">Submit</button>
				</div>
			</form>
		</div>
	</body>
</html>