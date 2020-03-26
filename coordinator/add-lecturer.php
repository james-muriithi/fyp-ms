<?php
include_once 'head.php'; ?>
<link rel="stylesheet" type="text/css" href="../assets/libs/jquery-nice-select/css/nice-select.css">
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
                                <li class="breadcrumb-item"><a href="#!">Lecturers</a> </li>
                                <li class="breadcrumb-item"><a href="#">Add Lecturer</a> </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- start row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Lecturer Details</h4>
                                    <div class="dropdown-divider"></div>

                                    <form class="add-lecturer-form">
                                        <div class="form-group form-row">
                                            <div class="col-sm-6">
                                                <label for="empid">Employee Id: </label>
                                                <input type="text" class="form-control" id="empid" placeholder="Enter employee Id" name="empid">
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
                                            <div class="col-sm-6">
                                                <label for="expertise">Expertise:</label>
                                                <input type="text" class="form-control" id="expertise" placeholder="Database Management" name="expertise">
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
    <script type="text/javascript" src="../assets/libs/bootstrap-validator/js/bootstrapValidator.min.js"></script>
</body>

</html>
<script type="text/javascript">
    $('.add-student-form').on('submit', function(event) {
        event.preventDefault();
    });

    $('.add-lecturer-form').bootstrapValidator({
            message: 'This value is not valid',
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
                            message: 'The registration number is required and cannot be empty'
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
            onSuccess: function (e,data) {
                $form = $(e.target);

                let formData = {}
                $form.serializeArray().map((v)=> formData[v.name] = v.value)

                $.post('../api/lecturer/',{...formData},(data)=>{
                    console.log(data)
                    Lobibox.notify('success', {
                        sound: false,
                        showClass: 'animated slideInDown',
                        hideClass: 'animated slideOutRight',
                        position: 'top right',
                        delayIndicator: false,
                        icon: 'fa fa-times',
                        rounded: true,
                        msg: data.success.message,
                    });
                }).fail((data)=>{
                    console.log(data)
                    let message = 'Some unexpected error occurred';
                    try{
                        message = data['responseJSON']['error']['message'];
                    }catch (e) {
                        console.error(message)
                    }
                    Lobibox.notify('error', {
                        sound: false,
                        showClass: 'animated slideInDown',
                        hideClass: 'animated slideOutRight',
                        position: 'top right',
                        delayIndicator: false,
                        icon: 'fa fa-times',
                        rounded: true,
                        msg: message,
                    });
                });

                $form
                    .bootstrapValidator('disableSubmitButtons', false)
                    .bootstrapValidator('resetForm', true);
            }
        })
        .on('status.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false);
    });
</script>