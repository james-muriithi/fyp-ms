<?php
include_once 'head.php';
require_once '../api/classes/Upload.php';
require_once '../api/classes/Project.php';
require_once '../api/classes/Student.php';
require_once '../api/classes/UploadCategory.php';

$uc = new UploadCategory($conn);
$upload = new Upload($conn);
$project = new Project($conn);
$student = new Student($conn);

function isPastDeadline($deadline){
    $remainingDays =  (strtotime($deadline) - strtotime(date('Y-m-d')) )/60/60/24;
    return $remainingDays <= 0;
}
?>
<link rel="stylesheet" type="text/css" href="../assets/libs/dropzone/dropzone.min.css">
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
                            <li class="breadcrumb-item"><a href="#!">Past Deadline</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- end page title -->
                <!-- start row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Past Deadline Uploads</h4>
                                <div class="dropdown-divider"></div>

                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsives nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Reg No</th>
                                        <th>Student</th>
                                        <th>Category</th>
                                        <th>Start Date</th>
                                        <th>Deadline</th>
                                        <th>Description</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                        $studentArr = $student->getAllUsers();
                                        foreach ($studentArr as $st){
                                            $ucArr = $uc->viewAllCategories();
                                            $student->setUsername($st['reg_no']);
                                            $pastDeadlineArr = [];
                                            if($project->studentHasProject($st['reg_no'])){
                                                $pid = $project->viewStudentProject($st['reg_no'])['id'];
                                                foreach ($ucArr as $category){
                                                    if (!$uc->hasUpload($pid, $category['id']) && isPastDeadline($category['deadline'])){
                                                        $category['student'] = $st;
                                                        $pastDeadlineArr[] = $category;
                                                    }
                                                }
                                            }
                                        }

                                        foreach ($pastDeadlineArr as $cat){  ?>
                                            <tr data-id="<?= $cat['id'] ?>">
                                                <td><?= $cat['student']['reg_no'] ?></td>
                                                <td><?= $cat['student']['full_name'] ?></td>
                                                <td><?= $cat['name'] ?></td>
                                                <td><?= $cat['start_date'] ?></td>
                                                <td><?= $cat['deadline'] ?></td>
                                                <td><?= $cat['description'] ?></td>
                                            </tr>
                                        <?php
                                        }
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

<!--edit modal-->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">
                    Edit Upload
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="dropzone edit-upload-form" id="single-file-upload">
                    <div class="fallback">
                        <input name="file" type="file" class="form-control" accept=".tar.gz, .docx, .pdf, .doc, .zip, .odf" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success waves-effect waves-light btn-save" form="single-file-upload">Edit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



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

<script type="text/javascript" src="../assets/libs/dropzone/dropzone.min.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
</body>
</html>
<script>
    //    edit-modal
    let category_id = '';
    $('.btn-edit').on('click', function (event) {
        let tr = $(this).closest('tr');
        category_id = tr.find('td:nth-child(4)').data('cid');
    });
    Dropzone.options.singleFileUpload = {
        paramName: "file", // The name that will be used to transfer the file
        url: 'test-upload.php',
        maxFilesize: 15, // MB
        maxFiles: 1,
        autoProcessQueue: false,
        acceptedFiles: '.tar.gz, .docx, .pdf, .doc, .zip, .odf',
        // Language Strings
        dictFileTooBig: "File is to big ({{filesize}}mb). Max allowed file size is {{maxFilesize}}mb",
        dictInvalidFileType: "Invalid File Type",
        dictCancelUpload: "Cancel",
        dictResponseError: "Server responded with {{statusCode}} code.",
        dictFallbackMessage: "hello",
        init: function () {
            let self = this;

            $('.edit-upload-form').on('submit',function (e) {
                e.preventDefault();
                if (self.files[0] == null){
                    toastr.error(`Please Select a file to upload of less than ${self.options.maxFilesize}MB`,'Sorry!', {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    })
                }else{
                    self.processQueue();
                }
            })
            this.on('sending', function (file, xhr, formData) {
                let student = '<?= $_SESSION['username'] ?>';
                formData.append('edit', true);
                formData.append('student', student)
                formData.append('category', category_id)
                console.log(category_id)
            })
            this.on("success", function(file,successMsg) {
                console.log(successMsg)
                let success = 'Your fle was uploaded successfully';
                try{
                    success = successMsg.success.message;
                    this.removeAllFiles();
                }catch (e) {
                    console.log(e)
                }
                toastr.success(success,'Bravoo!', {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut",
                    onHidden: function () {
                        location.reload();
                    }
                })
            });


            this.on("error", function(file,err) {
                console.log(err)
                let error = 'There was an error trying to upload your file. Please try again later.';
                file.status = Dropzone.QUEUED
                try{
                    error = err.error.message
                }catch (e) {
                    console.log(e)
                }
                $(file.previewElement).find('.dz-error-message').text(error);
                toastr.error(error,'Sorry!', {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut"
                })
            });


            this.on("addedfile", function() {
                if (this.files[1]!=null){
                    this.removeFile(this.files[0]);
                }
            });
        }

    };



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

</script>