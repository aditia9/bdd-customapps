<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Raffle App</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="//cdn.shopify.com/s/files/1/0330/6202/7397/files/logo.png?v=1582090061" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/webfont/webfont.min.js"></script>
    

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/atlantis.min.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/demo.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/js/plugin/UI/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugin/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugin/font-awesome-4-6-3/font-awesome.min.css">
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header-custom" data-background-color="default">
                
                <a href="https://porteegoods.myshopify.com/">
                    <img src="//cdn.shopify.com/s/files/1/0330/6202/7397/files/logo.png?v=1582090061" alt="navbar brand" class="navbar-brand">
                </a>
            </div>
            <!-- End Logo Header -->

        </div>
        <div class="panel-body-custom">
            <div class="three-front col hide" id="load-before-send">
                <div class="loaderna" id="loader-2">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div> 
            <?php
            echo $contents;
            ?>
        </div>
    </div>

    <script src="<?php echo base_url() ?>assets/backend/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/core/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/UI/jquery-ui.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url() ?>assets/frontend/js/custom.js"></script>
    
</body>