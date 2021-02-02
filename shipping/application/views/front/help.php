<div class="bg-primary2 pt-4 pb-5">
	<div class="container text-white py-2">
		<div class="align-items-center">
			<div class="text-center">
				<h1 class="mb-3">Manual Installation</h1>
				<h5 class="op-7 mb-3">Please be carefull this guide instruction requiring experience with HTML and Javascript, if you don't have any experience please contact us to helping your installation.</h5>
			</div>
		</div>
	</div>
</div>
<div class="container mt--5">
	<div class="page-inner mt--3">
		<div class="row">
			<div class="col-md-12 m-auto">
				<div class="card">
					<ul class="list" style="margin-top: 15px;">
						<li>
							Add new product with this spesification:
							<ul class="sub-list">
								<li>Product name: Product Code</li>
								<li>Product type: hidden-product</li>
							</ul>
						</li>
						<li>
						Please remind the product handle.
						</li>
						<li>You can find the product handle at the bottom of the edit product form, click Edit Website SEO and then copy the last characters of the URL and Handle
							<br>
						<img src="<?php echo base_url().'upload/handle-product.png' ?>" class="img-fluid" style="max-width: 420px"></li>
						<li>Edit your code, go to Online store <i class="fa fa-arrow-right"></i> themes. On the active themes click action and edit code</li>
						<li>Go to folder snippet and add new file with name <strong>bdd-uniquetrans.liquid</strong></li>
						<li>
							Add this script:
							<?php
							$data = "
{% assign product = all_products['CHANGE WITH YOUR PRODUCT HANDLE'] %}

{% if cart.item_count != 0 or product != '' or product.variants.first.available == true %}

  {% assign variant_id = product.variants.first.id %}

  <script>
  var cart_items = {{ cart.items | json }};
  var variant_id = {{ variant_id }};
  
  </script>

{% else %}
  <script>
  var cart_items = cart['items'];
  var variant_id = '0';
  
  </script>
{% endif %}";
echo "<pre>".htmlspecialchars($data, ENT_QUOTES)."</pre>";?>
						</li>
						<li>
							Go to <strong>theme.liquid</strong> and then add this script before tag <?php echo htmlspecialchars('</head>', ENT_QUOTES) ?>. <br>
							<?php
							$theme_script = "
{% include 'bdd-uniquetrans' %}
";
echo "<pre>".htmlspecialchars($theme_script, ENT_QUOTES)."</pre>";?>
						</li>
						<li>
							Input your product handle to this form <br>
						<img src="<?php echo base_url().'upload/form-manual.png' ?>" class="img-fluid" style="max-width: 420px;">

						</li>
					</ul>

					<!-- <h3>Optional Script</h3>
					<ul class="list">
						<li>
							Debut Themes
							<ul class="sub-list">
								<li>Go to file <strong>collection-template.liquid</strong></li>
								<li>Find </li>
							</ul>
						</li>
					</ul> -->
				</div>
			</div>
		</div>
	</div>
</div>