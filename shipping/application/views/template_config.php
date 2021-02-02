<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>JNE Apps</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="http://themekita.com/demo-atlantis-lite-bootstrap/livepreview/examples/assets/img/icon.ico" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/webfont/webfont.min.js"></script>
    

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/atlantis2.css">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/demo.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/js/plugin/UI/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugin/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugin/font-awesome-4-6-3/font-awesome.min.css">
</head>
<body>

    <div class="wrapper horizontal-layout-3">
        <div class="main-header no-box-shadow align-items-center" data-background-color="blue2">
            <div class="nav-top">
                <div class="container flex-row">
                    <div class="text-center text-white">
                        <h4 class="text-center logo">JNE Apps</h4>
                    </div>
                    <!-- <button class="navbar-toggler sidenav-toggler2 ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <i class="icon-menu"></i>
                        </span>
                    </button>
                    <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                    

                    <nav class="navbar navbar-header-left navbar-expand-lg p-0">
                        <ul class="navbar-nav page-navigation pl-md-3">
                            <h3 class="title-menu d-flex d-lg-none"> 
                                Menu 
                                <div class="close-menu"> <i class="flaticon-cross"></i></div>
                            </h3>
                            <li class="nav-item active">
                                <a class="nav-link" href="#">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Apps
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Projects
                                </a>
                            </li>
                            
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
                    </nav> -->
                    <!-- End Navbar -->
                </div>
            </div>
        </div>
        

        <div class="main-panel">  
            <div class="three col hide" id="load-before-send">
                <div class="loaderna" id="loader-2">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>    
            <?php echo $contents ?>
        </div>

       

        
    </div>

</body>

<!--   Core JS Files   -->
    <script src="<?php echo base_url() ?>assets/backend/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/core/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Datatables -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/custom.js"></script>

    <!-- Sweet Alert -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugin/select2/select2.js"></script>
    <script src="<?php echo base_url() ?>assets/plugin/printThis.js"></script>
    <!-- Atlantis JS -->
    <script src="<?php echo base_url() ?>assets/frontend/js/atlantis2.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/UI/jquery-ui.min.js"></script>
</html>
