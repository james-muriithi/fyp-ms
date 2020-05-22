<?php
include_once 'head.php';
$lecArray = $student->getAllUsers();
$student = new Student($conn);
$studentArray = $student->getAllUsers();
?>
<link rel="stylesheet" type="text/css" href="../assets/libs/slimselect/slimselect.min.css">
<link rel="stylesheet" type="text/css" href="../assets/libs/bootstrap-validator/css/bootstrapValidator.css">

<style type="text/css">
    .form-control {
        height: 42px;
        border-radius: 5px;
        box-shadow: none;
        font-family: sans-serif;
    }
</style>

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
                            <li class="breadcrumb-item"><a href="#!"><i class="fa fa-cloud-upload-alt"></i> Projects</a> </li>
                            <li class="breadcrumb-item"><a href="#">Add Project</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- end page title -->
                <!-- start row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Project Details</h4>
                                <div class="dropdown-divider"></div>

                                <form class="add-project-form">
                                    <div class="form-group form-row">
                                        <div class="col-sm-12">
                                            <label for="project_title">Title: </label>
                                            <input type="text" class="form-control" id="project_title" placeholder="e.g. Church management system " name="project_title">
                                        </div>
                                    </div>
                                    <div class="form-group form-row d-none">
                                        <div class="col-sm-12">
                                            <input type="text" hidden class="form-control" name="student" value="<?= $_SESSION['username'] ?>">
                                        </div>
                                    </div>

                                    <div class="form-group form-row">
                                        <div class="col-sm-12">
                                            <label for="p-cat">Project Category:</label>
                                            <select id="p-cat" name="category">
                                                <option value="1">Web App</option>
                                                <option value="2">Android App</option>
                                                <option value="3">Desktop App</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group form-row">
                                        <div class="col-sm-12">
                                            <label for="description">Description:</label>
                                            <textarea name="description" id="description" cols="30" rows="6" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="text-center my-5">
                                        <button type="submit" class="btn btn-primary p-t-8 p-b-8 p-l-20 p-r-20">
                                            Save <i class="fa fa-save"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  end row -->
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
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="../assets/libs/slimselect/slimselect.min.js"></script>
<script type="text/javascript" src="../assets/libs/bootstrap-validator/js/bootstrapValidator.min.js"></script>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        let select3 = new SlimSelect({
            select: '#p-cat',
            closeOnSelect: true
        });

        $('.add-project-form').on('submit', function(event) {
            event.preventDefault();
        });

        $('.add-project-form').bootstrapValidator({
            message: 'This value is not valid',
            excluded:':disabled',
            feedbackIcons: {
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh'
            },
            fields:{
                'project_title' : {
                    message: 'The title is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The title of the project is required and cannot be empty. '
                        },
                        stringLength: {
                            min: 5,
                            max: 40,
                            message: 'The title must be more than 5 and less than 40 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9'\s]+$/,
                            message: 'The title can only consist of alphabetical, numbers, underscores and hyphen'
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

                'category':{
                    message: 'The description is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Please select a project category'
                        }
                    }
                }
            },
            onSuccess: function (e) {
                $form = $(e.target);
                let formData = {}
                $form.serializeArray().map((v)=> formData[v.name] = v.value)

                $.post('../api/project/',{...formData},(data)=>{
                    console.log(data)
                    toastr.success(data.success.message, "Bravoo!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });
                }).fail((data)=>{
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
                });


                $form
                    .bootstrapValidator('disableSubmitButtons', false)
                    .bootstrapValidator('resetForm', true);
                select.set('')
                select2.select('')
            }
        })
            .on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            });
    });
</script>