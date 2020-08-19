<?php include_once 'head.php'; session_start(); ?>
<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-validator/css/bootstrapValidator.css">
<link rel="stylesheet" type="text/css" href="assets/libs/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="assets/libs/toastr/toastr.css">
<style type="text/css">
    .form-control {
        height: 42px;
        border-radius: 5px;
        box-shadow: none;
        font-family: sans-serif;
    }
</style>
<body onload="preloader();">

    <!-- preloader -->
    <div class="la-anim-1"></div>

    <div class="account-pages mt-5 m-b-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary">
                            <div class="text-primary text-center p-4">
                                <h5 class="text-white font-size-20">Welcome Back !</h5>
                                <p class="text-white-50">Sign in to continue.</p>
                                <a href="Javascript:void(0)" class="logo logo-admin">
                                    <img src="assets/images/logo-sm.png" height="60" alt="logo">
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="p-3">
                                <form class="form-horizontal mt-4 login-form">

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password" name="password">
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                <label class="custom-control-label" for="customControlInline">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-primary w-md waves-effect waves-light p-b-8 p-t-8" type="submit">Log In <i class="p-l-2 mdi mdi-login"></i></button>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <p class="text-bold">Student Credentials</p>
                                        <span>username: <i>SB30/pu/41760/16</i></span><br>
                                        <span>password: <i>9641</i></span>

                                        <p class="text-bold mt-1">Supervisor Credentials</p>
                                        username: <i>m3456</i><br>
                                        password: <i>0000</i>
                                    </div>

                                    <div class="form-group mt-2 mb-0 row">
                                        <div class="col-12 mt-4">
                                            <a href="confirm-username.php"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="m-t-5 text-center">
                        <p>Don't have an account ? <a href="confirm-username.php" class="font-weight-medium text-primary"> Signup now </a> </p>
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
    <script type="text/javascript" src="assets/libs/toastr/toastr.min.js"></script>

</body>
</html>
<?php
if (isset($_SESSION['error'])){
    echo '<script>toastr.error("'.$_SESSION['error'].'", "Ooops!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });</script>';
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])){
    echo '<script>toastr.success("'.$_SESSION['success'].'", "Bravoo!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });</script>';
    unset($_SESSION['success']);
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.login-form').on('submit', function(event) {
            event.preventDefault();
        });

        $('.login-form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh'
            },
            fields:{
                'username':{
                    excluded: 'false',
                    validators:{
                        notEmpty: {
                            message: 'Please provide a username to login.'
                        }
                    }
                },
                'password':{
                    excluded: 'false',
                    validators:{
                        notEmpty: {
                            message: 'Please provide a password to login.'
                        }
                    }
                }
            },
            onSuccess: function (e,data) {
                // alert("message");
                $form = $(e.target);
                $name = $.trim($('input[name="username"]').val())
                $password = $.trim($('input[name="password"]').val())
                $.post('api/Auth/', {name: $name, password: $password}, function(data, textStatus, xhr) {
                    // data = JSON.parse(data)
                    console.log(data);
                    if(typeof data.payload.level != 'undefined'){
                        let level = data.payload.level;
                        if (Number(level) == 2 || Number(level) == 1) {
                            location.href = 'coordinator/'
                        }else{
                            location.href = 'student/'
                        }
                    }
                }).fail(function(data){
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
        });
    }).on('status.field.bv', function(e, data) {
      data.bv.disableSubmitButtons(false);
    });

    let inProgress = false;

    let preloader = function() {
        if (inProgress) return false;
        inProgress = true;
        $('.account-pages').css({
            'opacity': '0.5',
            'pointer-events': 'none'
        });

        $('.account-pages').addClass('disabled');
        $('.la-anim-1').addClass('la-animate')
        setTimeout(function() {
            $('.account-pages').css({
                opacity: '1',
                'pointer-events': 'auto'
            });
            $('.account-pages').removeClass('disabled');
            $('.la-anim-1').removeClass('la-animate');
            inProgress = false;
        }, 1800);
    }
</script>