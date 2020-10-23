<?php
include_once 'head.php';
if($_SESSION['level'] !== 1){
    $_SESSION['error'] = 'You do not have permission to view that page';
    ?>
    <script>
        location.href = 'view-upload-category.php';
    </script>
    <?php
    http_response_code(403);
    die();
}
?>
<link rel="stylesheet" type="text/css" href="../assets/libs/jquery-nice-select/css/nice-select.css">
<link rel="stylesheet" type="text/css" href="../assets/libs/bootstrap-validator/css/bootstrapValidator.css">
<link rel="stylesheet" type="text/css" href="../assets/libs/daterangepicker/daterangepicker.css">
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
                            <li class="breadcrumb-item"><a href="#">Add Category</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- end page title -->
                <!-- start row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Upload Details</h4>
                                <div class="dropdown-divider"></div>

                                <form class="add-category-form">
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

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<!-- JAVASCRIPT -->
<?php include_once 'js.php'; ?>
<script type="text/javascript" src="../assets/libs/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script type="text/javascript" src="../assets/libs/bootstrap-validator/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="../assets/libs/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../assets/libs/daterangepicker/daterangepicker.js"></script>
<script src="assets/js/app.js" type="text/javascript"></script>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('select').niceSelect();
        let x = $('#period').daterangepicker({
            startDate: moment(),
            locale:{
                separator: ' To ',
                format: 'YYYY-MM-DD'
            }
        });
        let startDate = $('#period').data('daterangepicker').startDate.format('YYYY-MM-DD')
        let endDate = $('#period').data('daterangepicker').endDate.format('YYYY-MM-DD')

        x.on('apply.daterangepicker', (e, picker) => {
            startDate = picker.startDate.format('YYYY-MM-DD')
            endDate = picker.endDate.format('YYYY-MM-DD')
        })

        $('.add-category-form').on('submit', function(event) {
            event.preventDefault();
        });

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