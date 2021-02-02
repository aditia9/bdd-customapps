console.log('tes');
document.getElementById("bdd-track-order").innerHTML='\
<form action="https://bdd.services/track-order/private_apps" method="post" id="bdd-form-track-order" style="width: 100%; \
    max-width: 420px; \
    display: block; \
    margin: auto; \
    text-align: center;"> \
    <label class="control-label">No. Order</label> \
<input type="text" name="no_order" id="no_order" placeholder="1001" class="form-control"/> \
<button type="submit" class="btn btn-primary" style="margin-top:5px;">Cari</button>\
</form> \
';

$(document).ready(function() {
	$("#bdd-form-track-order").submit(function(e) {
		var form = $(this);
        var url = form.attr('action');

		$.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            success: function(response){
                console.log(response);
            }
        });
	});
});
