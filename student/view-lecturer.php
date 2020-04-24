<?php
include_once 'head.php';
$lecturer = new Lecturer($conn);
$lecArray = $lecturer->getAllUsers();
?>
<link rel="stylesheet" type="text/css" href="../assets/libs/bootstrap-validator/css/bootstrapValidator.css">
<link rel="stylesheet" type="text/css" href="../assets/libs/jquery-nice-select/css/nice-select.css">


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
                                <li class="breadcrumb-item"><a href="#!">Lecturers</a> </li>
                                <li class="breadcrumb-item"><a href="#!">View Lecturers</a> </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- start row -->
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Lecturers</h4>
                                        <div class="dropdown-divider"></div>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsives nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Assigned Students</th>
                                                    <th>Phone No</th>
                                                    <th>Email</th>
                                                    <th>Expertise</th>
                                                    <th>Role</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($lecArray as $row){ ?>
                                                    <tr data-lec="<?= $row['emp_id'] ?>">
                                                        <td><?= $row['full_name'] ?></td>
                                                        <td>
                                                            <?= $row['no_of_projects'] ?>
                                                            <a href="#" data-toggle="modal" data-target="#viewModal" class="text-right text-underline pl-2 btn-view">view</a>
                                                        </td>
                                                        <td><?= $row['phone_no'] ?></td>
                                                        <td><?= $row['email'] ?></td>
                                                        <td><?= $row['expertise'] ?></td>
                                                        <td data-role="<?= $row['coordinator'] == 'True' ? 1 : 0 ?>">
                                                        <span class="badge <?= $row['coordinator'] == 'True' ? 'badge-warning': 'badge-primary' ?>">
                                                            <?= $row['coordinator'] == 'True' ? 'Coordinator': 'Supervisor' ?>
                                                        </span>
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
                    <form id="edit-lecturer-form">
                        <div class="form-group form-row">
                            <div class="col-sm-6">
                                <label for="empid">Employee Id: </label>
                                <input type="text" class="form-control" id="empid" readonly placeholder="Enter employee Id" name="empid">
                            </div>
                            <div class="col-sm-6">
                                <label for="name">Full Name:</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter full name" name="name">
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <div class="col-sm-6">
                                <label for="regno">Email: </label>
                                <input type="email" class="form-control" id="email" placeholder="john@doe.com" name="email">
                            </div>
                            <div class="col-sm-6">
                                <label for="phone">Phone No:</label>
                                <input type="text" class="form-control" id="phone" placeholder="0712345678" name="phone">
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <?php
                            if ($_SESSION['level'] === 1) { ?>
                                <div class="col-sm-6">
                                    <label for="role">Role:</label>
                                    <select name="role" id="role" class="wide">
                                        <option value="0">Supervisor</option>
                                        <option value="1">Coordinator</option>
                                    </select>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="col-sm-6">
                                <label for="expertise">Expertise:</label>
                                <input type="text" class="form-control" id="expertise" placeholder="Database Management" name="expertise">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light btn-save" form="edit-lecturer-form">Edit</button>
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
                        Delete Lecturer
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

    <!-- Required datatable js -->
    <script type="text/javascript" src="../assets/libs/DataTables/datatables.min.js"></script>

    <!-- Datatable init js -->
    <script src="../assets/js/pages/datatables.init.js"></script>

    <script type="text/javascript" src="../assets/libs/toastr/toastr.min.js"></script>

    <script type="text/javascript" src="../assets/libs/bootstrap-validator/js/bootstrapValidator.min.js"></script>

    <!-- niceselect -->
    <script type="text/javascript" src="../assets/libs/jquery-nice-select/js/jquery.nice-select.min.js"></script>

    <script src="../assets/js/app.js" type="text/javascript" ></script>

    <script type="text/javascript" src="assets/js/app.js"></script>
    <?php include_once 'footer.php'; ?>
</body>
</html>
<script>
    $('select').niceSelect();
    //    delete modal
    let deleteLecturer = '';
    $('.btn-delete').on('click', function (event) {
        let tr = $(this).closest('tr'),
            full_name = tr.find('td:nth-child(2)').text();
        deleteLecturer = tr.find('td:nth-child(1)').text();
        $('span.student_name').text(full_name);
    });

    $('.btn-del').on('click', function (event) {
        $.ajax({
            url: '../api/lecturer/',
            data: JSON.stringify({emp_id: deleteLecturer}),
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
    })

    //edit modal
    $('.btn-edit').on('click', function (event) {
        let tr = $(this).closest('tr'),
            full_name = tr.find('td:nth-child(2)').text(),
            empId = tr.find('td:nth-child(1)').text(),
            phone = tr.find('td:nth-child(4)').text(),
            email = tr.find('td:nth-child(5)').text(),
            expertise = tr.find('td:nth-child(6)').text(),
            role = tr.find('td:nth-child(7)').data('role')

        $('input#empid').val(empId)
        $('input#name').val(full_name)
        $('input#email').val(email)
        $('input#phone').val(phone)
        $('input#expertise').val(expertise)
        $(`select#role`).val(role).niceSelect('update')
    });

    $('#edit-lecturer-form').on('submit', (e) => e.preventDefault())
    $('#edit-lecturer-form').bootstrapValidator({
        message: 'This value is not valid',
        excluded:':disabled',
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields:{
            'empid' : {
                validators: {
                    //when empty it will bring this error message
                    notEmpty: {
                        message: 'The employee id is required and cannot be empty'
                    },
                    //this is a regular expression to validate registration number
                    stringLength: {
                        min: 3,
                        message: 'Please provide an employee id of 3 or more characters'
                    }
                }
            },
            'phone':{
                validators:{
                    notEmpty: {
                        message: 'The phone number is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^(0|\+?254)7(\d){8}$/,
                        message: 'Please provide a valid phone number'
                    }
                }
            },
            'name' : {
                message: 'The name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The full name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 5,
                        max: 40,
                        message: 'The full name must be more than 5 and less than 40 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+\s+[a-zA-Z\s]+$/,
                        message: 'The name can only consist of alphabetical and atlest two names'
                    }
                }
            },
            'email' : {
                message: 'The email is not valid',
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+\.([a-z]{2,4})$/i,
                        message: 'Please provide a valid email address'
                    }
                }
            },
            'expertise' : {
                message: 'The expertise is not valid',
                validators: {
                    notEmpty: {
                        message: 'The expertise is required and cannot be empty'
                    }
                }
            }
        },
        onSuccess: function (e) {
            $form = $(e.target);
            let formData = {}
            $form.serializeArray().map((v)=> formData[v.name] = v.value)
            console.log(formData)
            $.ajax({
                url: '../api/lecturer/',
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