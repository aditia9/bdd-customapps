var shop = Shopify.shop;
console.log('tes')
document.getElementById("bdd-track-order").innerHTML = ' \
<form action="https://bdd.services/tracking-order-colorbox/config/find_order" method="post" id="bdd-form-track-order" style="width: 100%; \
    max-width: 420px; \
    display: block; \
    margin: auto; \
    text-align: center;"> \
    <div><label class="control-label">No. Order</label> \
    <input type="text" name="no_order" id="no_order" placeholder="1000" class="form-control"/></div>\
    <div><label class="control-label">Email</label> \
    <input type="email" name="email_order" id="email_order" placeholder="john@gmail.com" class="form-control"/></div>\
    <input type="hidden" name="shop" id="shop" value="'+shop+'">\
    <button type="submit" class="btn btn-primary" style="margin-top:5px;">Cari</button>\
</form> \
<div class="hasil"></div>\
';

$(document).ready(function() {
	$("#bdd-form-track-order").submit(function(e) {
		e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');
        const formData = new FormData(this);
        var datana = form.serialize();

        $.ajax({
            type: "POST",
            url: url,
            data: formData, // serializes the form's elements.
            dataType: "text",
            cache: false,
            contentType: false,
            crossDomain:true,
            processData: false,
            success: function(response){
                console.log(response);
                $('#bdd-form-track-order').hide();
                $('.hasil').html(response);

                var obj = JSON.parse(response);
                if (obj.kode == 'nf'){
                	$('#bdd-form-track-order').show();
                    $('.hasil').hide();
                    alert(obj.messages);
                    location.reload();
                }
            },
            error: function(response) {
                console.log(response)
            }
        });
	});
});
