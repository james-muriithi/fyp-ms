<?php
include_once 'head.php';
include_once '../api/classes/Project.php';
$lecArray = $lec->getAllUsers();
?>
<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="../assets/libs/DataTables/datatables.min.css"/>

<link rel="stylesheet" type="text/css" href="../assets/libs/slimselect/slimselect.min.css">

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
                                <li class="breadcrumb-item"><a href="#!">Assign Students</a> </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- start row -->
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Available Supervisors</h4>

                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsives nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Employee Id</th>
                                                <th>Name</th>
                                                <th>Expertise</th>
                                                <th>Assigned Projects</th>
                                                <th>Phone No</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($lecArray as $row){ ?>
                                                <tr>
                                                    <td><?= $row['emp_id'] ?></td>
                                                    <td><?= $row['full_name'] ?></td>
                                                    <td><?= $row['expertise'] ?></td>
                                                    <td>
                                                        <?= $row['no_of_projects'] ?>
                                                        <a href="#" class="text-right text-underline pl-2 btn-view" data-toggle="modal" data-target="#viewModal">view</a>
                                                    </td>
                                                    <td><?= $row['phone_no'] ?></td>
                                                    <td><?= $row['email'] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($_SESSION['level'] === 1 || $_SESSION['username'] === $row['emp_id']){ ?>
                                                            <div class="text-center">
                                                                <button class="btn btn-sm btn-success btn-assign" data-toggle="modal" data-target="#myModal" id="btn-assign">
                                                                    Assign
                                                                </button>
                                                            </div>
                                                        <?php }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
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
<!--    view modal-->
    <div id="viewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">
                        Assigned projects to: <span class="lec-name"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="overflow-x: auto;">
                    <table class="table table-striped table-bordered dt-responsives mb-0 view-table">
                        <thead>
                        <tr>
                            <th scope="col">Project</th>
                            <th scope="col">Category</th>
                            <th scope="col">Reg No.</th>
                            <th scope="col">Student</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!-- end view modal-->
    <!-- assign modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">
                        Assign projects to: <span class="lec-name"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="assign-form">
                        <select id="students" multiple name="projects">

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
    <?php include_once 'js.php'; ?>
    <!-- Required datatable js -->
    <script type="text/javascript" src="../assets/libs/DataTables/datatables.min.js"></script>

    <!-- Datatable init js -->
    <script src="../assets/js/pages/datatables.init.js"></script>


    <script type="text/javascript" src="../assets/libs/slimselect/slimselect.min.js"></script>

    <script type="text/javascript" src="assets/js/app.js"></script>

</body>


</html>