<?php
include_once 'head.php';
require_once '../api/classes/UploadCategory.php';

$uc = new UploadCategory($conn);
?>
<link rel="stylesheet" type="text/css" href="../assets/libs/bootstrap-validator/css/bootstrapValidator.css">
<link rel="stylesheet" type="text/css" href="../assets/libs/daterangepicker/daterangepicker.css">

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
                            <li class="breadcrumb-item"><a href="#!">View Categories</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- end page title -->
                <!-- start row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Upload Categories</h4>
                                <div class="dropdown-divider"></div>

                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsives nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Start Date</th>
                                        <th>Deadline</th>
                                        <?php
                                        if ($_SESSION['level'] === 1){
                                        ?>
                                            <th>No. of Uploads</th>
                                            <?php
                                        }
                                        ?>
                                        <th>Description</th>
                                        <?php
                                        if ($_SESSION['level'] === 1){
                                        ?>
                                            <th>Action</th>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $catArray = $uc->viewAllCategories();
                                        foreach ($catArray as $cat){  ?>
                                            <tr data-id="<?= $cat['id'] ?>">
                                                <td><?= $cat['name'] ?></td>
                                                <td><?= $cat['start_date'] ?></td>
                                                <td><?= $cat['deadline'] ?></td>
                                                <?php
                                                if ($_SESSION['level'] === 1){
                                                ?>
                                                <td><?= $cat['no_of_uploads'] ?>
                                                    <a href="#" class="text-underline btn-view-uploads" data-toggle="modal" data-target="#viewModal"> view</a>
                                                </td>
                                                    <?php
                                                }
                                                ?>
                                                <td><?= $cat['description'] ?></td>
                                                <?php
                                                if ($_SESSION['level'] === 1){
                                                ?>
                                                    <td>
                                                        <div class="text-center">
                                                            <button class="btn btn-sm btn-success btn-edit" data-toggle="modal" data-target="#editModal">
                                                                <i class="mdi mdi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-target="#deleteModal" >
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
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
                    Edit Lecturer Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="edit-category-form">
                    <div class="form-group form-row">
                        <div class="col-sm-12">
                            <label for="category_name">Name: </label>
                            <input type="text" class="form-control" id="category_name" placeholder="e.g. Concept Paper, Chapter 1 " name="category_name">
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <div class="col-sm-12">
                            <label for="period">Duration:</label>
                            <input type="text" class="form-control" readonly id="period" placeholder="Pick a range with dates" name="period">
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <div class="col-sm-12">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" cols="30" rows="6" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success waves-effect waves-light btn-save" form="edit-category-form">Edit</button>
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
                    Delete Category
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h5 class="text-danger">Are you sure you want to delete <span class="student_name"></span>?
                    <br><br><span class="fs-14">P.S. This action is will delete all uploaded materials.</span>
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light btn-del"><i class="fa fa-trash"></i> Yes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /. deletemodal -->
<!--    view modal-->
<div id="viewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">
                    <span class="lec-name"></span> uploads
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="overflow-x: auto;">
                <table class="table table-striped table-bordered dt-responsives mb-0 view-table">
                    <thead>
                    <tr>
                        <th scope="col">File Name</th>
                        <th scope="col">Upload Time</th>
                        <th scope="col">Reg No.</th>
                        <th scope="col">Student</th>
                        <th scope="col">Status</th>
<!--                        <th scope="col">Action</th>-->
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
<script type="text/javascript" src="../assets/libs/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../assets/libs/bootstrap-validator/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="../assets/libs/daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src="../assets/libs/toastr/toastr.min.js"></script>


<script type="text/javascript" src="assets/js/app.js"></script>
<?php include_once 'footer.php'; ?>
</body>
</html>
<script>
    //    delete modal
    let deleteCategory = '';
    $('.btn-delete').on('click', function (event) {
        let tr = $(this).closest('tr'),
            c_name = tr.find('td:nth-child(1)').text();
        deleteCategory = tr.data('id');
        $('span.student_name').text(c_name);
    });

    $('.btn-del').on('click', function (event) {
        $.ajax({
            url: '../api/upload-category/',
            data: JSON.stringify({category : deleteCategory}),
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

    //edit modal

    let x = $('#period').daterangepicker({
        startDate: moment(),
        locale:{
            separator: ' To ',
            format: 'YYYY-MM-DD'
        }
    });

    $('.btn-edit').on('click', function (event) {
        let tr = $(this).closest('tr'),
            c_name = tr.find('td:nth-child(1)').text(),
            startDate = tr.find('td:nth-child(2)').text(),
            deadLine = tr.find('td:nth-child(3)').text(),
            description = tr.find('td:nth-child(5)').text()
        deleteCategory = tr.data('id');

        $('input#category_name').val(c_name)
        $('textarea#description').val(description)

        $('#period').data('daterangepicker').setStartDate(startDate)
        $('#period').data('daterangepicker').setEndDate(deadLine);
    });

    $('#edit-category-form').on('submit', (e) => e.preventDefault())
    $('#edit-category-form').bootstrapValidator({
        message: 'This value is not valid',
        excluded:':disabled',
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields:{
            'category_name' : {
                message: 'The name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The name of the upload is required and cannot be empty e.g. Chapter 1 '
                    },
                    stringLength: {
                        min: 5,
                        max: 40,
                        message: 'The name must be more than 5 and less than 40 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9-_\s]+$/,
                        message: 'The name can only consist of alphabetical, numbers, underscores and hyphen'
                    }
                }
            },
            'description' : {
                message: 'The description is not valid',
                validators: {
                    notEmpty: {
                        message: 'The description is required and cannot be empty'
                    }
                }
            },
            'period' : {
                message: 'The dates are not valid',
                validators: {
                    notEmpty: {
                        message: 'The duration is required and cannot be empty'
                    }
                }
            }

        },
        onSuccess: function (e) {
            let startDate = $('#period').data('daterangepicker').startDate.format('YYYY-MM-DD')
            let endDate = $('#period').data('daterangepicker').endDate.format('YYYY-MM-DD')

            $form = $(e.target);
            let formData = {}
            $form.serializeArray().map((v)=> formData[v.name] = v.value)
            formData['category'] = deleteCategory;
            formData['startDate'] = startDate;
            formData['endDate'] = endDate;

            $.ajax({
                url: '../api/upload-category/',
                data: JSON.stringify({...formData}),
                method: 'PATCH',
                dataType: 'json',
                processData: false,
                contentType: 'application/merge-patch+json',
                success: function (data) {
                    toastr.success(data.success.message, "Bravoo!", {
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
                        console.error(message)
                    }
                    toastr.error(message, "Ooops!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });

                }

            });

            $form
                .bootstrapValidator('disableSubmitButtons', false)
                .bootstrapValidator('resetForm', true);
            $('#editModal').modal('hide');
        }
    })
        .on('status.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false);
        });
</script>