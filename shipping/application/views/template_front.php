<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kode unik apps</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?php echo base_url() ?>/assets/img/icon-bdd.ico" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/webfont/webfont.min.js"></script>
    

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/atlantis2.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/demo.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/js/plugin/UI/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugin/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugin/font-awesome-4-6-3/font-awesome.min.css">
</head>
<body>

    <div class="wrapper horizontal-layout-3">
        <div class="main-header no-box-shadow" data-background-color="yellow">
            <div class="nav-top">
                <div class="container d-flex flex-row">
                    <button class="navbar-toggler sidenav-toggler2 ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <img src="<?php echo base_url() ?>assets/backend/img/icon-menu.png" style="width: 100%; max-width: 25px;">
                        
                    </button>
                    <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="icon-menu"></i>
                        </button>
                    </div>
                    <!-- Logo Header -->
                    <!-- <a href="index-2.html" class="logo d-flex align-items-center">
                        <img src="https://themekita.com/demo-atlantis-bootstrap/livepreview/examples/assets/img/logo.svg" alt="Bolehdicobadigital" class="navbar-brand">
                    </a> -->
                    <!-- End Logo Header -->

                    <!-- Navbar Header -->
                    <nav class="navbar navbar-header-left navbar-expand-lg p-0">
                        <ul class="navbar-nav page-navigation pl-md-3">
                            <h3 class="title-menu d-flex d-lg-none"> 
                                Menu 
                                <div class="close-menu"> <i class="flaticon-cross"></i></div>
                            </h3>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url() ?>">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Demo
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url().'front/addstore/' ?>">
                                    Install
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url().'front/faq/' ?>">
                                    FAQ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url().'front/help/' ?>">
                                    Help
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url().'front/privacypolicy/' ?>">
                                    Privacy Policy
                                </a>
                            </li>
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pages
                                </a>
                            </li> -->
                        </ul>
                    </nav>
                    <nav class="navbar navbar-header navbar-expand-lg p-0">
                        <div class="container-fluid p-0">
                            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                                <li class="nav-item dropdown hidden-caret">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                                        <form class="navbar-left navbar-form nav-search">
                                            <div class="input-group">
                                                <input type="text" placeholder="Search ..." class="form-control">
                                            </div>
                                        </form>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <!-- End Navbar -->
                </div>
            </div>
        </div>

        <div class="main-panel">      
            <?php echo $contents ?>
        </div>

        <div class="bottom">
            <div class="container pt-3" id="contact">
                <div class="contact">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="h2 text-left">Don't have a shopify account?</div>
                            Don't hesitate to switch to shopify and make your online store now!
                            <div class="btn-action">
                                <a href="https://www.shopify.com/?ref=bdd1" target="_blank" class="btn btn-primary">Create Shopify Now</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="h2 text-left">Having troubles on developing shopify?</div>
                            We offer opportunities in collaboration to build your business.
                            <div class="btn-action">
                                <a href="https://bdd.services" target="_blank" class="btn btn-primary">See Our Offer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer id="sticky-footer" class="pb-4 pt-3 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-footer">
                        &copy; 2019 BolehDicobaDigital
                    </div>
                    <div class="col-md-6 text-right">
                        <img src="/assets/img/bdd-logo.png" class="img-fluid img-footer" alt="Boleh dicoba digital"/></a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</body>

<!--   Core JS Files   -->
    <script src="<?php echo base_url() ?>assets/backend/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/core/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <!-- <script src="<?php echo base_url() ?>assets/backend/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> -->

    

    <!-- jQuery Scrollbar -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


    <!-- Chart JS -->
    <!-- <script src="<?php echo base_url() ?>assets/backend/js/plugin/chart.js/chart.min.js"></script> -->

    <!-- jQuery Sparkline -->
    <!-- <script src="<?php echo base_url() ?>assets/backend/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script> -->

    <!-- Chart Circle -->
    <!-- <script src="<?php echo base_url() ?>assets/backend/js/plugin/chart-circle/circles.min.js"></script> -->

    <!-- Datatables -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <!-- <script src="<?php echo base_url() ?>assets/backend/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script> -->

    <!-- jQuery Vector Maps -->
    <!-- <script src="<?php echo base_url() ?>assets/backend/js/plugin/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script> -->

    <!-- Sweet Alert -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugin/select2/select2.js"></script>
    <script src="<?php echo base_url() ?>assets/plugin/printThis.js"></script>
    <!-- Atlantis JS -->
    <script src="<?php echo base_url() ?>assets/frontend/js/atlantis2.min.js"></script>
    <!-- <script src="<?php echo base_url() ?>assets/frontend/js/demo.js"></script> -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/UI/jquery-ui.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/custom.js"></script>
</html>
