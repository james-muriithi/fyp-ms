<?php
include_once 'head.php';
require_once '../api/classes/Upload.php';
require_once '../api/classes/Project.php';
require_once  '../api/classes/UploadCategory.php';

$upload = new Upload($conn);
$uc = new UploadCategory($conn);

$ucArr = $uc->viewAllCategories();
$deadlineArr = [];
foreach ($ucArr as $cat){
    $remainingDays =  (strtotime($cat['deadline']) - strtotime(date('Y-m-d')) )/60/60/24;
    if ($remainingDays <= 3 && $remainingDays >= 0){
        array_push($deadlineArr, $cat);
    }
}

?>
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
                            <div class="card mini-stat bg-primary text-white">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <div class="float-left mr-4">
                                            <img src="assets/images/services-icon/assigned.svg" alt="assigned students" width="70">
                                        </div>
                                        <?php
                                        $project = new Project($conn);
                                        $allProjects = $project->viewAllProjects();

                                        $allUploads = $upload->viewAllUploads();

                                        $studentUploads = [];

                                        foreach ($allUploads as $upl){
                                            if ( (string)$_SESSION['username'] === (string)$upl['reg_no'] ){
                                                array_push($studentUploads, $upl);
                                            }
                                        }
                                        ?>
                                        <h5 class="fs-16 text-uppercase mt-0 text-white-50">Uploads</h5>
                                        <h4 class="font-weight-medium font-size-24" data-counter="counterup" data-value="<?= count($studentUploads) ?>">0</h4>
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
                                        <h5 class="fs-16 text-uppercase mt-0 text-white-50">Deadlines</h5>
                                        <h4 class="font-weight-medium font-size-24" data-counter="counterup"
                                            data-value="<?= count($deadlineArr) ?>">0</h4>
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id='calendar'></div>

                                    <div style='clear:both'></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <?php include_once 'js.php'; ?>
    <script src="../assets/libs/moment/min/moment.min.js"></script>
    <script src="../assets/libs/fullcalendar/fullcalendar.min.js"></script>
    <script src="assets/js/filesaver.js"></script>
    <script src="assets/js/ics.min.js"></script>

    <!-- Calendar init -->
    <script src="../assets/js/pages/calendar.init.js"></script>

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