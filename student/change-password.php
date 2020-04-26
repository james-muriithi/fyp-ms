<?php
include_once 'head.php'; ?>
<link rel="stylesheet" type="text/css" href="../assets/libs/jquery-nice-select/css/nice-select.css">
<link rel="stylesheet" type="text/css" href="../assets/libs/bootstrap-validator/css/bootstrapValidator.css">
<link rel="stylesheet" type="text/css" href="../assets/libs/dropzone/dropzone.min.css">
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
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a> </li>
                            <li class="breadcrumb-item"><a href="#">Change Password</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- end page title -->
                <!-- start row -->
                <div class="row">
                    <div class="col-md-7 ">
                        <div class="card card-topline-purple">
                            <div class="card-body">
                                <h4 class="card-title">Change Password</h4>
                                <div class="dropdown-divider"></div>

                                <form class="change-password-form">
                                    <div class="form-group form-row">
                                        <div class="col-sm-12">
                                            <label for="old_password">Old Password: </label>
                                            <input type="text" class="form-control" id="old_password" placeholder="Enter your old password" name="old_password">
                                        </div>
                                    </div>

                                    <div class="form-group form-row">
                                        <div class="col-sm-12">
                                            <label for="password">New Password:</label>
                                            <input type="password" class="form-control" id="password" placeholder="Enter your new password" name="password">
                                        </div>
                                    </div>

                                    <div class="form-group form-row">
                                        <div class="col-sm-12">
                                            <label for="c-password">Confirm Password:</label>
                                            <input type="password" class="form-control" id="c-password" placeholder="Confirm your new password" name="c-password">
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

                    <div class="col-md-5">
                        <div class="card text-left card-topline-aqua">
                            <div class="card-body">
                                <!--                                <h4 class="card-title">single upload</h4>-->
                                <div class="row" >
                                    <div class="profile-userpic w-100">
                                        <?php
                                        $uploadDir = 'assets/images/users/';
                                        $image = empty($studentDetails['profile']) ? $uploadDir.'avatar-st.png': $uploadDir. $studentDetails['profile'];
                                        if (!file_exists($image)){
                                            $image = $uploadDir.'avatar-st.png';
                                        }
                                        ?>
                                        <img src="<?= $image ?>" class="img-responsive" alt="" style="display:inline-block;">
                                        <button style="display:inline-block;" class="m-l-4 d-none btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="profile-usertitle">
                                    <div class="profile-usertitle-name"><?= $studentDetails['full_name'] ?> </div>
                                    <div class="profile-usertitle-email">
                                        <a href="mailto:<?= $studentDetails['email'] ?>"><i class="fa fa-envelope"></i> <?= $studentDetails['email'] ?> </a>
                                        <span style="font-size: 25px" class="text-warning">|</span>
                                        <a href="tel:<?= $studentDetails['phone_no'] ?>"><i class="fa fa-phone-square"></i> <?= $studentDetails['phone_no'] ?> </a>
                                    </div>
                                </div>
                                <form class="dropzone" id="single-file-upload" action="#">
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </form>

                                <div style="text-align:center;" class="m-t-20">
                                    <button class="btn btn-primary" type="submit" id="upload-profile">
                                        <i class="fa fa-cloud-upload-alt"></i> Upload
                                    </button>
                                </div>
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
<!-- JAVASCRIPT -->
<?php include_once 'js.php'; ?>
<script type="text/javascript" src="../assets/libs/bootstrap-validator/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="../assets/libs/dropzone/dropzone.min.js"></script>
</body>
</html>
<script type="text/javascript">
    Dropzone.options.singleFileUpload = {
        paramName: "file", // The name that will be used to transfer the file
        url: 'test.php',
        maxFilesize: 2, // MB
        maxFiles: 1,
        autoProcessQueue: false,
        acceptedFiles: 'image/*',
        // Language Strings
        dictFileTooBig: "File is to big ({{filesize}}mb). Max allowed file size is {{maxFilesize}}mb",
        dictInvalidFileType: "Invalid File Type",
        dictCancelUpload: "Cancel",
        dictResponseError: "Server responded with {{statusCode}} code.",
        dictFallbackMessage: "hello",
        init: function () {
            let self = this;

            $('body').on('click','button#upload-profile',function (e) {
                if (self.files[0] == null){
                    toastr.error(`Please Select an image file to upload of less than ${self.options.maxFilesize}MB`,'Sorry!', {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    })
                }else{
                    self.processQueue();
                }
            })
            this.on("success", function(file,successMsg) {
                let success = 'Your image was uploaded successfully';
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
                let error = 'There was an error trying to upload your image. Please try again later.';
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
    $(document).ready(function () {

        $('ul#side-menu').find('li:not(.menu-title)').first().addClass('mm-active').children('a').addClass('active');

        $('.d-menu a:eq(2)').addClass('active')


        $('.change-password-form').on('submit', function(event) {
            event.preventDefault();
        });

        $('.change-password-form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh'
            },
            fields:{
                'old_password':{
                    validators:{
                        notEmpty: {
                            message: 'The old password is required and cannot be empty'
                        }
                    }
                },
                'password' : {
                    message: 'The password is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The password is required and cannot be empty'
                        },
                        identical: {
                            field: 'c-password',
                            message: 'The two passwords are not the same'
                        }
                    }
                },
                'c-password':{
                    excluded: 'false',
                    validators:{
                        notEmpty: {
                            message: 'Please confirm your password.'
                        },
                        identical: {
                            field: 'password',
                            message: 'The two passwords are not the same'
                        }
                    }
                }

            },
            onSuccess: function (e,data) {
                $form = $(e.target);

                let formData = {}
                $form.serializeArray().map((v)=> formData[v.name] = v.value)
                formData['regno'] = "<?= $_SESSION['username'] ?>";

                $.ajax({
                    url: '../api/student/',
                    data: JSON.stringify({change_password: {...formData}}),
                    method: 'PATCH',
                    dataType: 'json',
                    processData: false,
                    contentType: 'application/merge-patch+json',
                    success: function (data) {
                        toastr.success(data.success.message, "Bravoo!", {
                            showMethod: "slideDown",
                            hideMethod: "fadeOut"
                        });
                    },
                    error: function (data) {
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
            }
        })
            .on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            });
    })
</script>