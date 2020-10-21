<?php 
$this->session = \Config\Services::session();
$this->session->start(); 
?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.wrappixel.com/demos/admin-templates/admin-pro/main/index4.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Jun 2020 15:07:17 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    



    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url() ?>/assets/images/favicon.png">
    <title><?= $title; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url() ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="<?=base_url() ?>/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url() ?>/assets/plugins/datatables.net-bs4/css/responsive.dataTables.min.css">
    <!-- This page CSS -->
    <link rel="stylesheet" href="<?=base_url() ?>/assets/plugins/dropify/dist/css/dropify.min.css">
    <!--alerts CSS -->
    <link href="<?=base_url() ?>/assets/plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
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


<body class="fix-header fix-sidebar card-no-border">
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
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header>
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="<?=base_url() ?>">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="<?=base_url() ?>/assets/images/logo-icon.png" alt="homepage" class="dark-logo" /> </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse col-md-12" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item"> 
                            <a class="nav-link" href="#">
                                <span class="hide-menu">Home </span>
                            </a>
                        </li>
                        <?php 
                            if ($this->session->user_group == "admin") {
                                echo "<li class='nav-item dropdown'> 
                                        <a class='nav-link dropdown-toggle nav-item' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            Pengaturan
                                        </a>
                                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                            <a class='dropdown-item' href='".base_url()."/golongan'>Golongan</a>
                                            <a class='dropdown-item' href='".base_url()."/jabatan'>Jabatan</a>
                                            <a class='dropdown-item' href='".base_url()."/pangkat'>Pangkat</a>
                                            <a class='dropdown-item' href='".base_url()."/kesatuan'>Kesatuan</a>
                                            <a class='dropdown-item' href='".base_url()."/location'>Lokasi</a>
                                            <a class='dropdown-item' href='".base_url()."/hospital'>Rumah Sakit</a>
                                            <a class='dropdown-item' href='".base_url()."/employee'>Pegawai</a>
                                        </div>
                                    </li>
                                    <li class='nav-item'> 
                                        <a class='nav-link' href='".base_url()."/artikel'>
                                            <span class='hide-menu'>Artikel</span>
                                        </a>
                                    </li>
                                    <li class='nav-item'> 
                                        <a class='nav-link' href='".base_url()."/employee/listmedis'>
                                            <span class='hide-menu'>Tim Medis</span>
                                        </a>
                                    </li>
                                    <li class='nav-item'> 
                                        <a class='nav-link' href='".base_url()."/panic/history'>
                                            <span class='hide-menu'>Panic History</span>
                                        </a>
                                    </li>
                                    <li class='nav-item'> 
                                        <a class='nav-link' href='".base_url()."/admission'>
                                            <span class='hide-menu'>Rekam Medis</span>
                                        </a>
                                    </li>";
                            } else if ($this->session->user_group == "cc") {
                                echo "<li class='nav-item'> 
                                        <a class='nav-link' href='".base_url()."/panic/history'>
                                            <span class='hide-menu'>Panic History</span>
                                        </a>
                                    </li>
                                    <li class='nav-item'> 
                                        <a class='nav-link' href='".base_url()."/employee/listmedis'>
                                            <span class='hide-menu'>Tim Medis</span>
                                        </a>
                                    </li>";
                            } else {
                                if ($this->session->user_group == "admin" || $this->session->user_group == "cc") {
                                    session()->setFlashdata('error', 'Anda tidak boleh masuk');
                                    return redirect()->to(base_url('/'));
                                }
                            }
                            
                        ?>
                        
                        
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <a href="<?= base_url()?>/login/logout" class="nav-item nav-link">Logout</a>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

       <?= $this->renderSection('content'); ?>

         <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2020 Lavita Bella </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    
    <script src="<?=base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="<?=base_url() ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?=base_url() ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=base_url() ?>/assets/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="<?=base_url() ?>/assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?=base_url() ?>/assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=base_url() ?>/assets/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- Sweet-Alert  -->
    <script src="<?=base_url() ?>/assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?=base_url() ?>/assets/plugins/sweetalert2/sweet-alert.init.js"></script>
    <!-- This is data table -->
    <script src="<?=base_url() ?>/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?=base_url() ?>/assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <!--sparkline JavaScript -->
    <script src="<?=base_url() ?>/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jQuery file upload -->
    <script src="<?=base_url() ?>/assets/plugins/dropify/dist/js/dropify.min.js"></script>
    <script>
      
        $(function () {
            $('#myTable').DataTable();
            $(document).ready(function () {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function (settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;
                        api.column(2, {
                            page: 'current'
                        }).data().each(function (group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                    }
                });
                // Order by the grouping
                $('#example tbody').on('click', 'tr.group', function () {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        $('#config-table').DataTable({
            responsive: true
        });
    </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?=base_url() ?>/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>


<!-- Mirrored from www.wrappixel.com/demos/admin-templates/admin-pro/main/index4.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Jun 2020 15:07:21 GMT -->
</html>