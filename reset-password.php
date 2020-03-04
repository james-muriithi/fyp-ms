<?php include_once 'head.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-validator/css/bootstrapValidator.css">
<style type="text/css">
    .form-control {
        height: 42px;
        border-radius: 5px;
        box-shadow: none;
        font-family: sans-serif;
    }
</style>
<body>

    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary">
                            <div class="text-primary text-center p-4">
                                <h5 class="text-white font-size-20">Set Password</h5>
                                <p class="text-white-50">Hello Smith, enter your new password!</p>
                                <a href="javascript:void(0)" class="logo logo-admin">
                                    <img src="assets/images/users/user-6.jpg" class="rounded-circle" height="70" alt="logo">
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="p-3">
                                <form class="form-horizontal mt-4 password-form">

                                    <div class="form-group">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" name="password"placeholder="Enter password">
                                    </div>

                                    <div class="form-group">
                                        <label for="cpassword">Confirm Password</label>
                                        <input type="password" class="form-control" id="cpassword" name="repeat-password" placeholder="Confirm your password">
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-primary w-md waves-effect waves-light p-b-8 p-t-8" type="submit">Save Password</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="mt-5 text-center">
                        <p>Not you ? return <a href="index.php" class="font-weight-medium text-primary"> Sign In </a> </p>
                        <p class="mb-0 text-success">© <script>document.write(new Date().getFullYear())</script> FYPMS.
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/libs/bootstrap-validator/js/bootstrapValidator.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <script src="assets/js/app.js"></script>

</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('.password-form').on('submit', function(event) {
            event.preventDefault();
        });

        $('.password-form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh'
            },
            fields:{
                'password':{
                    excluded: 'false',
                    validators:{
                        notEmpty: {
                            message: 'Please provide a password to login.'
                        },
                        identical: {
                            field: 'repeat-password',
                            message: 'The two passwords are not the same'
                        }
                    }
                },
                'repeat-password':{
                    excluded: 'false',
                    validators:{
                        identical: {
                            field: 'password',
                            message: 'The two passwords are not the same'
                        }
                    }
                }
            },
            onSuccess: function (data) {
                alert("message");
            }
        });
    }).on('status.field.bv', function(e, data) {
      data.bv.disableSubmitButtons(false);
    });
</script>