<?php
include_once 'head.php';
$project = new Project($conn);
$projectArray = $project->viewAllProjects();
?>


<link rel="stylesheet" type="text/css" href="../assets/libs/slimselect/slimselect.min.css"/>

<body data-sidebar="dark">
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
                            <li class="breadcrumb-item"><a href="#!">Projects</a> </li>
                            <li class="breadcrumb-item"><a href="#!">View Projects</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- end page title -->
                <!-- start row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Projects</h4>
                                <div class="dropdown-divider"></div>

                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsives nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>No of Uploads</th>
                                        <th>Reg No</th>
                                        <th>Name</th>
                                        <th>Supervisor</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($projectArray as $proj){ ?>
                                        <tr>
                                            <td><?= $proj['id'] ?></td>
                                            <td><?= $proj['title'] ?></td>
                                            <td><?= $proj['category'] ?></td>
                                            <td><?= $proj['no_of_uploads'] ?></td>
                                            <td><?= $proj['reg_no'] ?></td>
                                            <td><?= $proj['full_name'] ?></td>
                                            <td>
                                                <?= empty($proj['supervisor']) ? '<button class="btn btn-sm btn-primary btn-assign">Assign</button>': $proj['supervisor'] ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($proj['status'] == 'in progress'){ ?>
                                                    <button class="btn btn-sm btn-warning"><?= $proj['status'] ?></button>
                                               <?php }elseif ($proj['status'] == 'complete'){ ?>
                                                    <button class="btn btn-sm btn-success"><?= $proj['status'] ?></button>
                                                <?php }else{ ?>
                                                    <button class="btn btn-sm btn-danger"><?= $proj['status'] ?></button>
                                                <?php }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#editModal" id="btn-edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" id="btn-delete">
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
                    </div> <!-- end col -->
                </div> <!-- end row -->
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
<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">
                    Assign Students to: <span class="lec-name"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="assign-form">
                    <select id="students" multiple name="sel">
                        <optgroup label="JavaScript">
                            <option value="value 1">Angular</option>
                            <option value="value 2">React</option>
                            <option value="value 3">Vue</option>
                        </optgroup>
                        <optgroup label="CSS">
                            <option value="value 4">Bootstrap</option>
                            <option value="value 5">Foundation</option>
                            <option value="value 6">Bulma</option>
                        </optgroup>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success waves-effect waves-light" form="assign-form">Assign</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<!-- JAVASCRIPT -->
<script src="../assets/libs/jquery/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/libs/metismenu/metisMenu.min.js"></script>
<script src="../assets/libs/simplebar/simplebar.min.js"></script>
<script src="../assets/libs/node-waves/waves.min.js"></script>
<script src="../assets/js/app.js" type="text/javascript" ></script>

<!-- Required datatable js -->
<script type="text/javascript" src="../assets/libs/DataTables/datatables.min.js"></script>

<!-- Datatable init js -->
<script src="../assets/js/pages/datatables.init.js"></script>

<!-- Sweet Alerts js -->
<script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- slimselect -->
<script type="text/javascript" src="../assets/libs/slimselect/slimselect.min.js"></script>


<script type="text/javascript" src="assets/js/app.js"></script>
</body>
</html>