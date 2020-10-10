<?= $this->extend('layout/template'); ?>
    

    <?=  $this->section('content'); ?>
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Dashboard 4</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Apps</li>
                        <li class="breadcrumb-item active">Dashboard 4</li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            
                <!-- ============================================================== -->
                <!-- Stats box -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center"><img src="../../assets/images/icon/income.png" alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Total Income</h6>
                                        <h2 class="m-t-0">953,000</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center"><img src="../../assets/images/icon/expense.png" alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Total Expense</h6>
                                        <h2 class="m-t-0">236,000</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center"><img src="../../assets/images/icon/assets.png" alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Total Assets</h6>
                                        <h2 class="m-t-0">987,563</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center"><img src="../../assets/images/icon/staff.png" alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Total Staff</h6>
                                        <h2 class="m-t-0">987,563</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Sales overview chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h3 class="card-title m-b-5"><span class="lstick"></span>Sales Overview </h3>
                                    </div>
                                    <div class="ml-auto">
                                        <select class="custom-select b-0">
                                            <option selected="">January 2017</option>
                                            <option value="1">February 2017</option>
                                            <option value="2">March 2017</option>
                                            <option value="3">April 2017</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="sales-overview2" class="p-relative" style="height:360px;"></div>
                                <div class="stats-bar">
                                    <div class="row text-center">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="p-20">
                                                <h6 class="m-b-0">Total Sales</h6>
                                                <h3 class="m-b-0">$10,345</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="p-20">
                                                <h6 class="m-b-0">This Month</h6>
                                                <h3 class="m-b-0">$7,589</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="p-20">
                                                <h6 class="m-b-0">This Week</h6>
                                                <h3 class="m-b-0">$1,476</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h3 class="card-title m-b-5"><span class="lstick"></span>Sales Overview </h3>
                                    </div>
                                    <div class="ml-auto">
                                        <select class="custom-select b-0">
                                            <option selected="">January 2017</option>
                                            <option value="1">February 2017</option>
                                            <option value="2">March 2017</option>
                                            <option value="3">April 2017</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="ct-sales3-chart" class="p-relative" style="height:360px;"></div>
                                <div class="stats-bar">
                                    <div class="row text-center">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="p-20">
                                                <h6 class="m-b-0">Total Sales</h6>
                                                <h3 class="m-b-0">$10,345</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="p-20">
                                                <h6 class="m-b-0">This Month</h6>
                                                <h3 class="m-b-0">$7,589</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="p-20">
                                                <h6 class="m-b-0">This Week</h6>
                                                <h3 class="m-b-0">$1,476</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h3 class="card-title m-b-5"><span class="lstick"></span>Total Visits </h3>
                                    </div>
                                    <div class="ml-auto">
                                        <select class="custom-select b-0">
                                            <option selected="">January 2017</option>
                                            <option value="1">February 2017</option>
                                            <option value="2">March 2017</option>
                                            <option value="3">April 2017</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="visitfromworld" style="width:100%!important; height:415px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><span class="lstick"></span>Browser Stats</h4>
                                <table class="table browser m-t-30 no-border">
                                    <tbody>
                                        <tr>
                                            <td style="width:40px"><img src="../../assets/images/browser/chrome-logo.png" alt=logo /></td>
                                            <td>Google Chrome</td>
                                            <td class="text-right">23%</td>
                                        </tr>
                                        <tr>
                                            <td><img src="../../assets/images/browser/firefox-logo.png" alt=logo /></td>
                                            <td>Mozila Firefox</td>
                                            <td class="text-right">15%</td>
                                        </tr>
                                        <tr>
                                            <td><img src="../../assets/images/browser/safari-logo.png" alt=logo /></td>
                                            <td>Apple Safari</td>
                                            <td class="text-right">07%</td>
                                        </tr>
                                        <tr>
                                            <td><img src="../../assets/images/browser/internet-logo.png" alt=logo /></td>
                                            <td>Internet Explorer</td>
                                            <td class="text-right">09%</td>
                                        </tr>
                                        <tr>
                                            <td><img src="../../assets/images/browser/opera-logo.png" alt=logo /></td>
                                            <td>Opera mini</td>
                                            <td class="text-right">23%</td>
                                        </tr>
                                        <tr>
                                            <td><img src="../../assets/images/browser/edge-logo.png" alt=logo /></td>
                                            <td>Microsoft edge</td>
                                            <td class="text-right">09%</td>
                                        </tr>
                                        <tr>
                                            <td><img src="../../assets/images/browser/netscape-logo.png" alt=logo /></td>
                                            <td>Netscape Navigator</td>
                                            <td class="text-right">04%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Projects of the month -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="card-title"><span class="lstick"></span>Projects of the Month</h4></div>
                                    <div class="ml-auto">
                                        <select class="custom-select b-0">
                                            <option selected="">January 2017</option>
                                            <option value="1">February 2017</option>
                                            <option value="2">March 2017</option>
                                            <option value="3">April 2017</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive m-t-20">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Assigned</th>
                                                <th>Name</th>
                                                <th>Priority</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width:50px;"><span class="round"><img src="../../assets/images/users/1.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Sunil Joshi</h6><small class="text-muted">Web Designer</small></td>
                                                <td>Elite Admin</td>
                                                <td><span class="label label-success label-rounded">Low</span></td>
                                            </tr>
                                            <tr class="active">
                                                <td><span class="round"><img src="../../assets/images/users/2.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Andrew</h6><small class="text-muted">Project Manager</small></td>
                                                <td>Real Homes</td>
                                                <td><span class="label label-info label-rounded">Medium</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-success"><img src="../../assets/images/users/3.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Bhavesh patel</h6><small class="text-muted">Developer</small></td>
                                                <td>MedicalPro Theme</td>
                                                <td><span class="label label-primary label-rounded">High</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-primary"><img src="../../assets/images/users/4.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Nirav Joshi</h6><small class="text-muted">Frontend Eng</small></td>
                                                <td>Elite Admin</td>
                                                <td><span class="label label-danger label-rounded">Low</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-warning"><img src="../../assets/images/users/5.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Micheal Doe</h6><small class="text-muted">Content Writer</small></td>
                                                <td>Helping Hands</td>
                                                <td><span class="label label-success label-rounded">High</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-danger"><img src="../../assets/images/users/6.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Johnathan</h6><small class="text-muted">Graphic</small></td>
                                                <td>Digital Agency</td>
                                                <td><span class="label label-info label-rounded">High</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-primary"><img src="../../assets/images/users/4.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Nirav Joshi</h6><small class="text-muted">Frontend Eng</small></td>
                                                <td>Elite Admin</td>
                                                <td><span class="label label-danger label-rounded">Low</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- Activity widget find scss into widget folder-->
                    <!-- ============================================================== -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h4 class="card-title"><span class="lstick"></span>Activity</h4>
                                    <!-- <span class="badge badge-success">9</span> -->
                                    <div class="btn-group ml-auto m-t-10">
                                        <a href="JavaScript:void(0)" class="icon-options-vertical link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)">Action</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="javascript:void(0)">Separated link</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="activity-box">
                                <div class="card-body">
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="../../assets/images/users/2.jpg" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-0 font-medium">Mark Freeman <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">uploaded this file </h6>
                                            <table class="table vm b-0 m-b-0">
                                                <tr>
                                                    <td class="m-r-10 b-0"><img src="../../assets/images/icon/zip.png" alt="user" /></td>
                                                    <td class="b-0">
                                                        <h5 class="m-b-0 font-medium ">Homepage.zip</h5>
                                                        <h6>54 MB</h6></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="../../assets/images/users/3.jpg" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-5 font-medium">Emma Smith <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">joined projectname, and invited <a href="javascript:void(0)">@maxcage, @maxcage, @maxcage, @maxcage, @maxcage,+3</a></h6>
                                            <span class="image-list m-t-20">
                                                <a href="javascript:void(0)"><img src="../../assets/images/users/1.jpg" class="img-circle" alt="user" width="50"></a>
                                                <a href="javascript:void(0)"><img src="../../assets/images/users/2.jpg" class="img-circle" alt="user" width="50"></a>
                                                <a href="javascript:void(0)"><span class="round round-warning">C</span></a>
                                            <a href="javascript:void(0)"><span class="round round-danger">D</span></a>
                                            <a href="javascript:void(0)">+3</a>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="../../assets/images/users/4.jpg" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-0 font-medium">David R. Jones  <span class="text-muted font-14 m-l-10">| &nbsp; 9:30 PM, July 13th</span></h5>
                                            <h6 class="text-muted">uploaded this file </h6>
                                            <span>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="../../assets/images/big/img1.jpg" alt="user" width="60"></a>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="../../assets/images/big/img2.jpg" alt="user" width="60"></a>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="../../assets/images/users/6.jpg" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-5 font-medium">David R. Jones <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">Commented on<a href="javascript:void(0)">Test Project</a></h6>
                                            <p class="m-b-0">It has survived not only five centuries, but also the leap into electrotypesetting, remaining essentially unchanged.</p>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right panel -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- End Page Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme working">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../../assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../../assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../../assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../../assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../../assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../../assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../../assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../../assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
<?= $this->endSection(); ?>