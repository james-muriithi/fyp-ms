<?php
include_once 'head.php'; ?>


<body data-sidebar="dark" onload="preloader()">
    <!-- preloader -->
    <div class="la-anim-1"></div>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php include_once 'header.php'; ?>
        <!-- ========== Left Sidebar Start ========== -->
        <?php include_once 'sidebar.php'; ?>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row align-items-center">
                        <div class="col-sm-12 p-t-15">
                            <ul class=" breadcrumb breadcrumb-title float-right bg-transparent">
                                <li class="breadcrumb-item">
                                    <a href="index.php"><i class="mdi mdi-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Dashboard</a> </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card mini-stat bg-success text-white">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <div class="float-left mr-4">
                                            <img src="assets/images/services-icon/lecturer.svg" alt="lecturer" width="70">
                                        </div>
                                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Lecturers</h5>
                                        <h4 class="font-weight-medium font-size-24">
                                            <?php
                                            $lecturers = $lec->getAllUsers();
                                            $totalLecturers = count($lecturers);
                                            ?>
                                            <span class="people_in info-box-number" data-counter="counterup" data-value="<?= $totalLecturers ?>">0</span>
                                        </h4>
                                        <!-- <div class="mini-stat-label bg-secondary">
                                            <p class="mb-0">+ 12%</p>
                                        </div> -->
                                    </div>
                                    <div class="pt-2">
                                        <div class="float-right">
                                            <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                        </div>
                                        <p class="text-white-50 mb-0 mt-1">See more</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card mini-stat bg-primary text-white">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <div class="float-left mr-3">
                                            <img src="assets/images/services-icon/student.svg" alt="student" width="70">
                                        </div>
                                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Students</h5>
                                        <h4 class="font-weight-medium font-size-24">
                                            <?php
                                            $student = new Student($conn);
                                            $students = $student->getAllUsers();
                                            $totalStudents = count($students);
                                            ?>
                                            <span class="people_in info-box-number" data-counter="counterup" data-value="<?= $totalStudents ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="pt-2">
                                        <div class="float-right">
                                            <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                        </div>
                                        <p class="text-white-50 mb-0 mt-1">See more</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card mini-stat bg-warning text-white">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <div class="float-left mr-4">
                                            <img src="assets/images/services-icon/assigned.svg" alt="assigned students" width="70">
                                        </div>
                                        <h5 class="fs-16 text-uppercase mt-0 text-white-50">Assigned</h5>
                                        <h4 class="font-weight-medium font-size-24">60</h4>
                                        <div class="mini-stat-label bg-success">
                                            <p class="mb-0"> 91%</p>
                                        </div>
                                    </div>
                                    <div class="pt-2">
                                        <div class="float-right">
                                            <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                        </div>
                                        <p class="text-white-50 mb-0 mt-1">See more</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card mini-stat bg-danger text-white">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <div class="float-left mr-4">
                                            <img src="assets/images/services-icon/completed.svg" alt="" width="80">
                                        </div>
                                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Projects</h5>
                                        <h4 class="font-weight-medium font-size-24">36</h4>
                                    </div>
                                    <div class="pt-2">
                                        <div class="float-right">
                                            <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                        </div>
                                        <p class="text-white-50 mb-0 mt-1">See more</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- start row -->
                    <div class="row">
                        <div class="col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Project Categories</h4>
                                    <div class="chart-container" style="position: relative; height:33vh;">
                                        <canvas  id="ct-donut"></canvas>
                                    </div>

                                    <div class="mt-4">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <td><span class="badge badge-primary">Desktop Apps</span></td>
                                                    <td class="text-right d-app">54.5%</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge badge-success">Android Apps</span></td>
                                                    <td class="text-right a-app">28.0%</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge badge-warning">Web Apps</span></td>
                                                    <td class="text-right w-app">17.5%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Activity</h4>
                                    <ol class="activity-feed">
                                        <li class="feed-item">
                                            <div class="feed-item-list">
                                                <span class="date">Jan 22</span>
                                                <span class="activity-text">Responded to need “Volunteer
                                                    Activities”</span>
                                            </div>
                                        </li>
                                        <li class="feed-item">
                                            <div class="feed-item-list">
                                                <span class="date">Jan 20</span>
                                                <span class="activity-text">At vero eos et accusamus et iusto odio
                                                    dignissimos ducimus qui deleniti atque...<a href="#" class="text-success">Read more</a></span>
                                            </div>
                                        </li>
                                        <li class="feed-item">
                                            <div class="feed-item-list">
                                                <span class="date">Jan 19</span>
                                                <span class="activity-text">Joined the group “Boardsmanship
                                                    Forum”</span>
                                            </div>
                                        </li>
                                        <li class="feed-item">
                                            <div class="feed-item-list">
                                                <span class="date">Jan 17</span>
                                                <span class="activity-text">Responded to need “In-Kind
                                                    Opportunity”</span>
                                            </div>
                                        </li>
                                        <li class="feed-item">
                                            <div class="feed-item-list">
                                                <span class="date">Jan 16</span>
                                                <span class="activity-text">Sed ut perspiciatis unde omnis iste natus
                                                    error sit rem.</span>
                                            </div>
                                        </li>
                                    </ol>
                                    <div class="text-center">
                                        <a href="#" class="btn btn-primary">Load More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Latest Uploads</h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-centered table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Project</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Reg No.</th>
                                                    <th scope="col">Student</th>
                                                    <th scope="col">Uploaded</th>
                                                    <th scope="col">Download</th>
                                                    <th scope="col" colspan="2">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>School Management System</td>
                                                    <td>Concept paper</td>
                                                    <td>SB30/PU/41760/16</td>
                                                    <td>
                                                        <div>
                                                            <img src="assets/images/users/user-2.jpg" alt="" class="avatar-xs rounded-circle mr-2"> Philip Smead
                                                        </div>
                                                    </td>
                                                    <td>15/1/2018</td>
                                                    <td><a href="#">dowload</a></td>
                                                    <td><span class="badge badge-warning">Pending</span></td>
                                                    <td>
                                                        <div>
                                                            <a href="#" class="btn btn-success btn-sm">Approve <i class="mdi mdi-check"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Church Management System</td>
                                                    <td>Concept paper</td>
                                                    <td>SB30/PU/41761/16</td>
                                                    <td>
                                                        <div>
                                                            <img src="assets/images/users/user-2.jpg" alt="" class="avatar-xs rounded-circle mr-2"> Jane Doe
                                                        </div>
                                                    </td>
                                                    <td>15/1/2018</td>
                                                    <td><a href="#">dowload</a></td>
                                                    <td><span class="badge badge-success">approved</span></td>
                                                    <td>
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php include_once 'footer.php'; ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>
            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center">Choose Layouts</h6>
            <div class="p-4">
                <div class="mb-2">
                    <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
                    <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                </div>
                <div class="mb-2">
                    <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css" />
                    <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                </div>
            </div>
        </div>
    </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <?php include_once 'js.php'; ?>
</body>

</html>
<script>
    $(document).ready(function() {
        /************** Handles counterup plugin wrapper ****************/
        let handleCounterup = function() {
            if (!$().counterUp) {
                return;
            }

            $("[data-counter='counterup']").counterUp({
                delay: 10,
                time: 1000
            });
        };
        handleCounterup()
    });
</script>