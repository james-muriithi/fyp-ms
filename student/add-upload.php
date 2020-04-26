<?php
include_once 'head.php';
include_once '../api/classes/UploadCategory.php';
$uc = new UploadCategory($conn);
$ucArr = $uc->viewAllCategories();
?>
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
                            <li class="breadcrumb-item"><a href="#!"><i class="fa fa-cloud-upload-alt"></i> Uploads</a> </li>
                            <li class="breadcrumb-item"><a href="#">Add Upload</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- end page title -->
                <!-- start row -->
                <div class="alert alert-info alert-dismissible fade show d-nones" role="alert">
                    For every category, you can only upload once. If you wish to replace the current upload consider
                    <strong><a href="view-uploads.php" class="text-underline">editing</a></strong>. PS. you cannot edit if the deadline has passed.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Upload</h4>
                                    </div>
                                    <div class="col-6">
                                        <i class="fa fa-info-circle text-info float-r fs-20"></i>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>

                                <form class="add-upload-form" enctype="multipart/form-data">
                                    <div class="form-group form-row">
                                        <div class="col-sm-12">
                                            <label for="u-cat">Upload Category:</label>
                                            <select id="u-cat" name="category" class="wide" required>
                                                <?php
                                                foreach ($ucArr as $cat){
                                                    $remainingDays =  (strtotime($cat['deadline']) - strtotime(date('Y-m-d')) )/60/60/24;
                                                    if ($remainingDays  < 0){
                                                        continue;
                                                    }
                                                    ?>
                                                    <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group form-row">
                                        <div class="col-sm-12">
                                            <div class="dropzone" id="single-file-upload">
                                                <div class="fallback">
                                                    <input name="file" type="file" class="form-control" accept=".tar.gz, .docx, .pdf, .doc, .zip, .odf" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="text-center my-5">
                                        <button type="submit" class="btn btn-primary p-t-8 p-b-8 p-l-20 p-r-20">
                                            Upload <i class="fa fa-save"></i>
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

<!-- JAVASCRIPT -->
<?php include_once 'js.php'; ?>
<script type="text/javascript" src="../assets/libs/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script type="text/javascript" src="../assets/libs/bootstrap-validator/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="../assets/libs/dropzone/dropzone.min.js"></script>
</body>

</html>
<script type="text/javascript">
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

            $('.add-upload-form').on('submit',function (e) {
                e.preventDefault();
                if (self.files[0] == null){
                    toastr.error(`Please Select an image file to upload of less than ${self.options.maxFilesize}MB`,'Sorry!', {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    })
                }else{
                    self.processQueue();
                }
            })
            this.on('sending', function (file, xhr, formData) {
                let student = '<?= $_SESSION['username'] ?>';
                let category = $('select#u-cat').val();
                formData.append('student', student)
                formData.append('category', category)
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
    $(document).ready(function() {
        $('select').niceSelect();

        $('.add-category-form').bootstrapValidator({
            message: 'This value is not valid',
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
                $form = $(e.target);
                let formData = {}
                $form.serializeArray().map((v)=> formData[v.name] = v.value)
                formData['startDate'] = startDate;
                formData['endDate'] = endDate;

                $.post('../api/upload-category/',{...formData},(data)=>{
                    toastr.success(data.success.message, "Bravoo!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });
                }).fail((data)=>{
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
            }
        })
            .on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            });
    });
</script>