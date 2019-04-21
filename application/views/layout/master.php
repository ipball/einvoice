<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$sess = $this->session->userdata(app_session());
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title><?=$title?></title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?=base_url()?>assets/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->    
    <link href="<?=base_url()?>assets/node_modules/vue-datepicker-local/dist/vue-datepicker-local.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/node_modules/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?=base_url()?>assets/css/main.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->    
    <!-- CUSTOME STYLE -->
    <script>
        var $url = '<?=base_url()?>';
    </script>
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a class="link" href="<?=base_url()?>">
                    <span class="brand">Leave
                        <span class="brand-tip">Manage</span>
                    </span>
                    <span class="brand-mini">LM</span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">                    
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="<?=$sess['profile_picture']?>" alt="Profile" />
                            <span></span><?=$sess['name']?><i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <?php if(strtoupper($sess['role']) === 'ADMINISTRATOR') : ?>                            
                            <a class="dropdown-item" href="<?=base_url('setting')?>"><i class="fa fa-cog"></i>ตั้งค่าระบบ</a>
                            <?php else: ?>
                            <a class="dropdown-item" href="<?=base_url('employee/profile')?>"><i class="fa fa-user"></i>ข้อมูลของฉัน</a>
                            <?php endif; ?>                            
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" href="<?=base_url('authen/logout')?>"><i class="fa fa-power-off"></i>ออกจากระบบ</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <?php $this->load->view('layout/menu_admin', $sess); ?>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                <?php if(!empty($content)) echo $content; ?>
            </div>
            <!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="font-13">2019 © <b>BahtSoft.com</b> - All rights reserved.</div>
                <a class="px-4" href="https://www.bahtsoft.com" target="_blank">Contact me</a>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer>
        </div>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->

    <!-- Normal Modal -->
    <div class="modal fade modal-form" data-backdrop="static" data-keyboard="false" id="normalModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
    <!-- Large Modal -->
    <div class="modal fade modal-form" data-backdrop="static" data-keyboard="false" id="largeModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"></div>
        </div>
    </div>

    <!-- ALERT MESSAGE -->
    <?php if(!empty($this->session->flashdata('message'))): ?>
    <div class="alert alert-<?=$this->session->flashdata('message')['type']?> alert-dismissable fade show has-icon alert-message">
        <i class="ti-info-alt"></i>
        <?=$this->session->flashdata('message')['msg']?>
    </div>
    <?php endif;  ?>

    <!-- CORE PLUGINS-->
    <script src="<?=base_url()?>assets/node_modules/vue/dist/vue.min.js" type="text/javascript"></script>    
    <script src="<?=base_url()?>assets/node_modules/vue-datepicker-local/dist/vue-datepicker-local.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/metismenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>        

    <!-- PAGE LEVEL PLUGINS-->
    <script src="<?=base_url()?>assets/node_modules/axios/dist/axios.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/jquery-serializejson/jquery.serializejson.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/moment/min/moment.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/numeral/min/numeral.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/jquery-validation/dist/additional-methods.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/jquery-validation/dist/localization/messages_th.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/vendors/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?=base_url()?>assets/js/app.min.js" type="text/javascript"></script>
    <!-- CUSTOM SCript -->
    <script src="<?=base_url()?>assets/js/script.js" type="text/javascript"></script>    
    <!-- PAGE LEVEL SCRIPTS-->    
    <?php if(!empty($script)) echo '<script src="'.base_url().'assets/js/pages/'.$script.'" type="text/javascript"></script>'; ?>
</body>

</html>