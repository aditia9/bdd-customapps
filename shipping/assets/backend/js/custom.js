$(document).ready(function() {
    $('#waktu_ac').hide();
    $(".dpicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "2020:2030"
    });
    $('#sukses_notif').hide();
    $('.basic-datatables').DataTable({
        "pageLength": 10,
    });
    
    $("#form-configurasi").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/myproject/
        }else{
            var base_url = location.origin; // http://stackoverflow.com
        }
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            beforeSend: function() {
                $('#load-before-send').removeClass('hide');
            },
            success: function(response){
                if (response == '1') {
                    swal({title: "Success", text: "Configuration saved." , type: "success", icon: "success"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }
            }
        });
    });
    
    $("#edit_range").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/myproject/
        }else{
            var base_url = location.origin; // http://stackoverflow.com
        }
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            beforeSend: function() {
                $('#load-before-send').removeClass('hide');
            },
            success: function(response){
                if (response === '1') {
                    $('#sukses_notif').show();
                }
            }
        });
    });

    $("#manual-form").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/myproject/
        }else{
            var base_url = location.origin; // http://stackoverflow.com
        }
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            beforeSend: function() {
                $('#load-before-send').removeClass('hide');
            },
            success: function(response){
                if (response == '0') {
                    swal({title: "Error", text: "Product not found, Please read the documentation." , type: "error", icon: "error"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }else{
                    swal({title: "Success", text: "Configuration saved." , type: "success", icon: "success"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }
            }
        });
    });

    $("#request_install").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/myproject/
        }else{
            var base_url = location.origin; // http://stackoverflow.com
        }
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "json",
            beforeSend: function() {
                $('#load-before-send').removeClass('hide');
            },
            success: function(response){
                if (response == '0') {
                    swal({title: "Error", text: "Product not found, Please read the documentation." , type: "error", icon: "error"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }else{
                    swal({title: "Success", text: "Request sent" , type: "success", icon: "success"}).then(function(){ 
                        $('#load-before-send').addClass('hide');
                        location.reload();
                    });
                }
            }
        });
    });

});