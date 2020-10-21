<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.wrappixel.com/demos/admin-templates/admin-pro/main/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Jun 2020 15:08:29 GMT -->
<head>
    <style type="text/css">
        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
          color: white !important;
          opacity: 1; /* Firefox */
        }

        :-ms-input-placeholder { /* Internet Explorer 10-11 */
          color: white !important;
        }

        ::-ms-input-placeholder { /* Microsoft Edge */
          color: white !important;
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url() ?>/assets/images/favicon.png">
    <title>Login Page</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/adminpro/" />
    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url() ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- page css -->
    <link href="<?=base_url() ?>/assets/css/pages/login-register-lock.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=base_url() ?>/assets/css/style.css" rel="stylesheet">
    
    <!-- You can change the theme colors from here -->
    <link href="<?=base_url() ?>/assets/css/colors/default-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Lavita Bella</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="background-image:url(<?=base_url() ?>/assets/images/background/login-register.jpeg);">
                <div class="login-box card" style="background:rgba(0,0,0,0.5); border-radius: 10px;">
                    <div class="form-group m-t-20" style="margin-bottom: 0px;">
                                <div class="col-sm-12 text-center" style="display: flex; justify-content: center; align-items: center;" align="center">
                                    <img src="../assets/images/icon-baru-rev1.png" style="max-height: 100%; width: 80px; margin-right: 10px;">
                                    <h3 style="font-weight: bold; font-size: 18px; color: white;">Mang PeDeKa Medis</h3>
                                    <img src="../assets/images/Lambang_Polda_Sumsel.png" style="max-height: 100%; width: 60px; margin-left: 10px;">
                                </div>
                            </div>
                    <div class="card-body">
                        <?= csrf_field() ?>
                        <form class="form-horizontal form-material" id="loginform" action="/login/checklogin" method="post">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input style="color: white !important;" class="form-control" type="text" required="" name="username" id="username" placeholder="Username"> </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="password" required="" name="password" id="password" placeholder="Password"> </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12 p-b-20">
                                    <button style="opacity: 1 !important;" class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Log In</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            
        </div>
    </section>
    
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?=base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=base_url() ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?=base_url() ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
    
</body>


<!-- Mirrored from www.wrappixel.com/demos/admin-templates/admin-pro/main/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Jun 2020 15:08:30 GMT -->
</html>