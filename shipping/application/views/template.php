<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Tiga digit kode unik apps</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="http://themekita.com/demo-atlantis-lite-bootstrap/livepreview/examples/assets/img/icon.ico" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/webfont/webfont.min.js"></script>
    

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/atlantis.min.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/demo.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/js/plugin/UI/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugin/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugin/font-awesome-4-6-3/font-awesome.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="red2">
                
                <a href="index-2.html" class="logo">
                    <img src="http://themekita.com/demo-atlantis-lite-bootstrap/livepreview/examples/assets/img/logo.svg" alt="navbar brand" class="navbar-brand">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="red2">
                
                <div class="container-fluid">
                    <!-- <div class="collapse" id="search-nav">
                        <form class="navbar-left navbar-form nav-search mr-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control">
                            </div>
                        </form>
                    </div> -->
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="<?php echo base_url('upload/'.$this->session->userdata('photo'));?>" alt="avatar" class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <!-- <div class="avatar-lg"><img src="<?php echo base_url('upload/'.$this->session->userdata('photo'));?>" alt="image profile" class="avatar-img rounded"></div> -->
                                            <div class="u-text">
                                                <h4><?php echo $this->session->userdata('nama_user');?></h4>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo base_url().'user/edit/'.$this->session->userdata('id_user') ?>">My Profile</a>
                                        <div class="dropdown-divider"></div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo base_url('login/logout');?>">Logout</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-1" data-background-color="dark2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="<?php echo base_url('upload/'.$this->session->userdata('photo'));?>" alt="<?php echo $this->session->userdata('nama_user');?>" class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    <?php echo $this->session->userdata('nama_user');?>
                                    <span class="user-level">
                                    <?php
                                    $userna = $this->db->query("
                                        SELECT * FROM user
                                        JOIN groups ON user.id_groups = groups.id_groups
                                        WHERE user.id_user = ".$this->session->userdata('id_user')."
                                    ")->row();
                                    echo $userna->name_groups;
                                    ?>
                                    </span>
                                </span>
                            </a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <ul class="nav nav-primary">
                        <?php
                        $main = $this->db->query("select distinct a.* from tb_menu a join role_group b on a.id_menu = b.id_menu where b.id_group = '".$this->session->userdata('id_groups')."' and a.sub_menu = 0 order by a.id_menu asc");
                        foreach ($main->result() as $m) {
                        $sub = $this->db->query("select a.* from tb_menu a join role_group b on a.id_menu = b.id_menu where b.id_group = '".$this->session->userdata('id_groups')."' and a.sub_menu = '".$m->id_menu."' order by a.id_menu asc");
                        if ($sub->num_rows() > 0) { // Jika punya sub menu
                            if ($sub_menu == $m->id_menu) { // jika page aktif 
                                $aktif = 'active';
                                $expanded = 'true';
                                $open = 'show';
                                $navna = 'submenu';
                            }else{
                                $aktif = '';
                                $expanded = 'false';
                                $open = '';
                                $navna = '';
                            }
                            echo '
                            <li class="nav-item">
                                <a data-toggle="collapse" href="#'.$m->id_menu.'" class="collapsed" aria-expanded="'.$expanded.'" title="'.$m->id_menu.'">
                                    <i class="'.$m->icon.'"></i>
                                    <p>'.$m->nama_menu.'</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse '.$open.'" id="'.$m->id_menu.'">
                                    <ul class="nav nav-collapse">';
                                    foreach ($sub->result() as $s) {
                                        echo '
                                        <li class="'.$aktif.'">
                                            <a href="'.base_url().''.$s->link.'" title="'.$s->id_menu.'">
                                                <span class="sub-item">'.$s->nama_menu.'</span>
                                            </a>
                                        </li>';
                                    }
                            echo    '</ul>
                                </div>
                            </li>
                            ';
                            

                        }else { // Jika tdk punya sub menu
                            if ($page_id == $m->id_menu) {  // jika page aktif
                                $aktif_ = 'active';
                            }else{
                                $aktif_ = '';
                            }
                            echo '
                            <li class="nav-item '.$aktif_.'">
                                <a href="'.base_url().''.$m->link.'" title="'.$m->id_menu.'">
                                    <i class="'.$m->icon.'"></i>
                                    <p>'.$m->nama_menu.'</p>
                                </a>
                            </li>
                            ';
                        }

                        }
                        ?>
                        
                        <!-- <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Components</h4>
                        </li> -->
                        
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                     
                <?php echo $contents ?>
                
            </div>
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="<?php echo base_url() ?>assets/backend/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/core/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <!-- <script src="<?php echo base_url() ?>assets/backend/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> -->

    <script src="<?php echo base_url() ?>assets/backend/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

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
    <script src="<?php echo base_url() ?>assets/backend/js/atlantis.min.js"></script>
    <script src="<?php echo base_url() ?>assets/backend/js/plugin/UI/jquery-ui.min.js"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <!-- <script src="<?php echo base_url() ?>assets/backend/js/setting-demo.js"></script> -->
    <!-- <script src="<?php echo base_url() ?>assets/backend/js/demo.js"></script> -->
    <script src="<?php echo base_url() ?>assets/backend/js/custom.js"></script>
</body>

<!-- Mirrored from themekita.com/demo-atlantis-lite-bootstrap/livepreview/examples/demo1/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 May 2019 19:27:50 GMT -->
</html>