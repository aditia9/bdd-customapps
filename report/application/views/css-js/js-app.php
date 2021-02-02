<script type="text/javascript">

    function myFunction() {
        var x = document.getElementById("toAmount1").value;
        console.log(x);
        document.getElementById("amount").value = x;
    }
    function myFunction2() {
        var x = document.getElementById("toAmount2").value;
        console.log(x);
        document.getElementById("amount").value = x;
    }

    $(document).ready(function(){
      $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".search-result").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

    // disable ketika cek na 0
    $(".check-collection").change(function(){
        if($('.check-collection:checked').length > 0) {
            $('#create-bundling').attr('disabled', false);
        }
        else{
            $('#create-bundling').attr('disabled', true);
        }
    });

    // ambil data cek bundling
    $('#create-bundling').on('click', function(){
        var bundling_na = [];
        $('.check-collection').each(function(){
            if($(this).is(':checked')){
                bundling_na.push($(this).val());
            }
        });

        console.log(bundling_na)
        var url_shopify = $('#store').val();

        $.ajax({
            url : "<?=site_url('controller_app/select_bundling');?>",
            method : "POST",
            data : {bundling_na:bundling_na, url_shopify:url_shopify},
            success : function(data){
                // console.log(data);
                $('.bundling-selection').html(data);
                $('.display-collection').hide();
            },
            error: function (e) {
                console.log(e);
            }
        });

    });

    // cek bundling
    $(".check-bundling").change(function(){
        if($('.check-bundling:checked').length > 0) {
            $('#delete-bundling').attr('disabled', false);
        }
        else{
            $('#delete-bundling').attr('disabled', true);
        }
    });

    // ambil data cek bundling
    $('#delete-bundling').on('click', function(){
        var bundling_na = [];
        $('.check-bundling').each(function(){
            if($(this).is(':checked')){
                bundling_na.push($(this).val());
            }
        });

        console.log(bundling_na)
        var url_shopify = $('#store').val();

        $.ajax({
            url : "<?=site_url('controller_app/delete_bundling');?>",
            method : "POST",
            data : {bundling_na:bundling_na, url_shopify:url_shopify},
            success : function(data){
                location.reload();
            },
            error: function (e) {
                console.log(e);
            }
        });

    });

</script>