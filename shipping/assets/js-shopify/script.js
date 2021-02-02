var shop = Shopify.shop;
function get_bankna(){

    for (var i = 0; i < bankna.length; i++) {
        return bankna[i]
    }
}
document.getElementById("bdd-paid-confirmation").innerHTML = ' \
<form action="https://bdd.services/paid-confirm/front/tess" method="post" id="bdd-form-paid-confirmation" style="width: 100%; \
    max-width: 420px; \
    display: block; \
    margin: auto; \
    text-align: center;" enctype="multipart/form-data"> \
    <div> \
        <label class="control-label">No. Order</label> \
        <input type="text" name="no_order" id="no_order" placeholder="1001" class="form-control"/> \
    </div>\
    <div>\
        <label class="control-label">Email</label> \
        <input type="text" name="email_order" id="email_order" placeholder="john@gmail.com" class="form-control"/>\
    </div>\
    <div>\
        <label class="control-label">Transfer Date</label> \
        <input type="text" name="tgl_tf" id="tgl_tf" class="form-control dpicker"/>\
    </div>\
    <div>\
        <label class="control-label">Bank</label> \
        <select name="bayarke"><option value="0">Select Bank</option> </select> \
    </div>\
    <div>\
        <label class="control-label" style="display: block;">Transfer Proof</label> \
        <input type="file" name="bukti_tf" id="bukti_tf" class="form-control"/>\
        <input type="hidden" name="shop" id="shop" value="'+ shop +'">\
        <button type="submit" class="btn btn-primary" style="margin-top:5px;">Submit</button>\
    </div> \
</form> \
<div class="hasil"></div> \
';
    bankna.forEach(tes=>{
        $('select[name=bayarke]').append(`<option value="${tes}">${tes}</option>`);
    });

$(document).ready(function() {
    $("#bdd-form-paid-confirmation").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');
        const formData = new FormData(this);
        formData.append('token_store', token_store);
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
                var obj = JSON.parse(response);
                if (obj.kode <= 8){
                    $('.hasil').html(response);
                    $('#bdd-form-paid-confirmation').hide();
                }else{
                    $('.hasil').html(response);
                    $('#bdd-form-paid-confirmation').hide();
                }
            },
            error: function(response) {
                console.log(response)
            }
        });
    });
});
