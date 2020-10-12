<?php
include_once 'head.php';
require_once '../api/classes/Upload.php';
require_once '../api/classes/Project.php';

$upload = new Upload($conn);
$project = new Project($conn);
?>
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
                            <li class="breadcrumb-item"><a href="#!"><i class="fa fa-cloud-upload-alt"></i> Uploads</a> </li>
                            <li class="breadcrumb-item"><a href="#!">View Uploads</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- end page title -->
                <!-- start row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Student Uploads</h4>
                                <div class="dropdown-divider"></div>

                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsives nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                    $uploadArr = $upload->viewAllUploads();
                                    foreach ($uploadArr as $upl){
                                        if ($_SESSION['level'] !== 1 && !$project->isAssignedToMe($upl['pid'], $_SESSION['username'])){
                                            continue;
                                        }
                                        $uploadDir = str_replace('/','', $upl['reg_no']).'/'.$upl['category_id'].'/';
                                        $file = '../student/uploads/'.$uploadDir.$upl['name']
                                        ?>
                                        <tr data-id="<?= $upl['id'] ?>">
                                            <td>
                                                <a href="<?= $file ?>" download class="text-underline"><?= $upl['name'] ?></a>
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

<!-- reject modal -->
<div id="rejectModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">
                    Reject Upload
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h5 class="text-danger">Are you sure you want to reject the upload?
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger waves-effect waves-light btn-reject2"><i class="fa fa-times"></i> Yes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /. reject modal -->


<!-- undo modal -->
<div id="undoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">
                    Undo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h5 class="text-dark">Are you sure you want to return the upload to pending?
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-undo2"><i class="fa fa-check"></i> Yes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /. undo modal -->

<!-- approve modal -->
<div id="approveModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">
                    Approve Upload
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h5 class="text-success">Are you sure you want to approve the upload?
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-approve2"><i class="fa fa-check"></i> Yes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /. approve modal -->


<!-- delete modal -->
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">
                    Delete Upload
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h5 class="text-danger">Are you sure you want to delete <span class="student_name"></span>?
                    <br><br><span class="fs-14">P.S. This action is irreversible.</span>
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light btn-del"><i class="fa fa-trash"></i> Yes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /. deletemodal -->



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

<script type="text/javascript" src="../assets/libs/toastr/toastr.min.js"></script>


<script type="text/javascript" src="assets/js/app.js"></script>
</body>
</html>
<script>
    //    delete modal
    let upload_id = '';
    $('.btn-delete').on('click', function (event) {
        let tr = $(this).closest('tr');
        upload_id = tr.data('id');
    });

    $('.btn-del').on('click', function (event) {
        $.ajax({
            url: '../api/upload/',
            data: JSON.stringify({upload_id}),
            method: 'DELETE',
            dataType: 'json',
            processData: false,
            contentType: 'application/json',
            success: function (data) {
                //havent removed conn->rollback()
                toastr.success(`${data.success.message} doesn't delete though`, "Bravoo!", {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut",
                    onHidden: function () {
                        location.reload();
                    }
                });
            },
            error: function (data) {
                console.log(data)
                let message = 'Some unexpected error occurred';
                try{
                    message = data['responseJSON']['error']['message'];
                }catch (e) {
                    console.error(e)
                }
                toastr.error(message, "Ooops!", {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut"
                });

            }

        });
    });

//    approve modal
    $('.btn-approve').on('click', function (event) {
        let tr = $(this).closest('tr');
        upload_id = tr.data('id');
    });

    $('.btn-approve2').on('click', function (event) {
        $.ajax({
            url: '../api/upload/',
            data: JSON.stringify({approve: {upload_id}}),
            method: 'PATCH',
            dataType: 'json',
            processData: false,
            contentType: 'application/merge-patch+json',
            success: function (data) {
                //havent removed conn->rollback()
                toastr.success(`${data.success.message} doesn't delete though`, "Bravoo!", {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut",
                    onHidden: function () {
                        location.reload();
                    }
                });
            },
            error: function (data) {
                console.log(data)
                let message = 'Some unexpected error occurred';
                try{
                    message = data['responseJSON']['error']['message'];
                }catch (e) {
                    console.error(e)
                }
                toastr.error(message, "Ooops!", {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut"
                });

            }

        });
    });

//    undo
    $('.btn-undo').on('click', function (event) {
        let tr = $(this).closest('tr');
        upload_id = tr.data('id');
    });

    $('.btn-undo2').on('click', function (event) {
        $.ajax({
            url: '../api/upload/',
            data: JSON.stringify({undo: {upload_id}}),
            method: 'PATCH',
            dataType: 'json',
            processData: false,
            contentType: 'application/merge-patch+json',
            success: function (data) {
                //havent removed conn->rollback()
                toastr.success(`${data.success.message} doesn't delete though`, "Bravoo!", {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut",
                    onHidden: function () {
                        location.reload();
                    }
                });
            },
            error: function (data) {
                console.log(data)
                let message = 'Some unexpected error occurred';
                try{
                    message = data['responseJSON']['error']['message'];
                }catch (e) {
                    console.error(e)
                }
                toastr.error(message, "Ooops!", {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut"
                });

            }

        });
    });

//    reject
    $('.btn-reject').on('click', function (event) {
        let tr = $(this).closest('tr');
        upload_id = tr.data('id');
    });

    $('.btn-reject2').on('click', function (event) {
        $.ajax({
            url: '../api/upload/',
            data: JSON.stringify({reject: {upload_id}}),
            method: 'PATCH',
            dataType: 'json',
            processData: false,
            contentType: 'application/merge-patch+json',
            success: function (data) {
                //havent removed conn->rollback()
                toastr.success(`${data.success.message} doesn't delete though`, "Bravoo!", {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut",
                    onHidden: function () {
                        location.reload();
                    }
                });
            },
            error: function (data) {
                console.log(data)
                let message = 'Some unexpected error occurred';
                try{
                    message = data['responseJSON']['error']['message'];
                }catch (e) {
                    console.error(e)
                }
                toastr.error(message, "Ooops!", {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut"
                });

            }

        });
    });

</script>