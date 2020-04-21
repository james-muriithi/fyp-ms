<?php
include_once 'head.php';
require_once '../api/classes/Upload.php';
require_once '../api/classes/Project.php';

$upload = new Upload($conn);
?>
<link rel="stylesheet" type="text/css" href="../assets/libs/chart.js/Chart.min.css">

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
                                            <img src="assets/images/services-icon/completed.svg" alt="" width="80">
                                        </div>
                                        <?php
                                        $project = new Project($conn);
                                        $allProjects = $project->viewAllProjects();
                                        $totalProjects = count($allProjects);
                                        ?>
                                        <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Projects</h5>
                                        <h4 class="font-weight-medium font-size-24" data-counter="counterup" data-value="<?= $totalProjects ?>">0</h4>
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
                                            <img src="assets/images/services-icon/assigned.svg" alt="assigned students" width="70">
                                        </div>
                                        <?php
                                        $uploadArr = $upload->viewAllUploads();
                                        ?>
                                        <h5 class="fs-16 text-uppercase mt-0 text-white-50">Uploads</h5>
                                        <h4 class="font-weight-medium font-size-24" data-counter="counterup" data-value="<?= count($uploadArr) ?>">0</h4>
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
                                        <canvas  id="ct-donut" height="150"></canvas>
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
                                <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>

                                    <h4 class="card-title mb-4">Projects</h4>
                                    <canvas id="radar" height="400"></canvas>
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
                                                    <th scope="col">File Name</th>
                                                    <th scope="col">Upload Time</th>
                                                    <th scope="col">Project</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Reg No.</th>
                                                    <th scope="col">Student</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($uploadArr as $upl){
                                                $i++;
                                                if ($_SESSION['level'] !== 1 && !$project->isAssignedToMe($upl['pid'], $_SESSION['username'])){
                                                    continue;
                                                }
                                                if ($i > 10){
                                                    break;
                                                }
                                                ?>

                                                <tr data-id="<?= $upl['id'] ?>">
                                                    <td>
                                                        <a href="#" class="text-underline"><?= $upl['name'] ?></a>
                                                    </td>
                                                    <td><?= $upl['upload_time'] ?></td>
                                                    <td><?= $upl['project'] ?></td>
                                                    <td><?= $upl['category'] ?></td>
                                                    <td><?= $upl['reg_no'] ?></td>
                                                    <td><?= $upl['full_name'] ?></td>
                                                    <td>
                                                        <?php
                                                        if($upl['approved'] == 0){ ?>
                                                            <span class="badge badge-warning">Pending</span>
                                                        <?php }elseif($upl['approved'] == 1){ ?>
                                                            <span class="badge badge-success">Approved</span>
                                                        <?php }else{ ?>
                                                            <span class="badge badge-danger">Rejected</span>
                                                        <?php }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <?php
                                                            if($upl['approved'] == 0){ ?>
                                                                <button class="btn btn-sm badge-success btn-approve" data-toggle="modal" data-target="#approveModal">Approve</button>
                                                                <button class="btn btn-sm badge-danger btn-reject" data-toggle="modal" data-target="#rejectModal">Reject</button>
                                                            <?php }elseif($upl['approved'] == 1){ ?>
                                                                <button class="btn btn-sm badge-danger btn-undo" data-toggle="modal" data-target="#undoModal">Undo</button>
                                                            <?php }else{ ?>
                                                                <button class="btn btn-sm badge-danger btn-undo" data-toggle="modal" data-target="#undoModal">Undo</button>
                                                            <?php }
                                                            ?>
                                                            <button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#deleteModal" >
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
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
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <?php include_once 'js.php'; ?>

    <?php include_once 'footer.php'; ?>
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