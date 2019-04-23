<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>ระบบพิมพ์ใบกำกับภาษี, ใบเสร็จรับเงิน | Login</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?=base_url()?>assets/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?=base_url()?>assets/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="<?=base_url()?>assets/css/pages/auth-light.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" />
</head>

<body class="bg-silver-300">
    <div class="content">
        <div class="brand">
            <a class="link" href="<?=base_url('authen')?>">eInvoice System</a>
        </div>
        <form id="login-form" action="<?=base_url('authen/check_user')?>" method="post">
            <h2 class="login-title">Log in</h2>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Login</button>
            </div>            
        </form>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
     <!-- ALERT MESSAGE -->
     <?php if(!empty($this->session->flashdata('err_login_wrong'))): ?>
    <div class="alert alert-danger alert-dismissable fade show has-icon alert-message">
        <i class="ti-close"></i>
        <?=$this->session->flashdata('err_login_wrong')?>
    </div>
    <?php endif;  ?>
    <!-- CORE PLUGINS -->
    <script src="<?=base_url()?>assets/node_modules/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="<?=base_url()?>assets/node_modules/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?=base_url()?>assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <!-- CUSTOM SCript -->
    <script src="<?=base_url()?>assets/js/script.js" type="text/javascript"></script>   
</body>

</html>