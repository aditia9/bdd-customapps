$(document).ready(function() {
    $(".dpicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "2020:2030"
    });
	$("#submit_form_ac").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/myproject/
        }else{
            var base_url = location.origin; // http://stackoverflow.com
        }
        const formData = new FormData(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: formData, // serializes the form's elements.
            cache : false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('#load-before-send').removeClass('hide');
            },
            success: function(response){
                if (response['kode'] <= 8){
                	swal({title: "Error", text: response['messages'] , type: "error", icon: "error"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }if (response['kode'] == 'ok'){
                    swal({title: "Success", text: response['messages'] , type: "success", icon: "success"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }
            }
        });
    });

});