<?php include_once 'head.php'; 
session_start();
?>
<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-validator/css/bootstrapValidator.css">
<link rel="stylesheet" type="text/css" href="assets/libs/lobibox/css/lobibox.min.css">
<style type="text/css">
    .form-control {
        height: 42px;
        border-radius: 5px;
        box-shadow: none;
        font-family: sans-serif;
    }
</style>
<body onload="preloader();">
    <?php 
    if (!isset($_GET['t']) || empty($_GET['t'])) {
        $prevUrl = empty($_SERVER['HTTP_REFERER']) ? 'index.php' : $_SERVER['HTTP_REFERER'];
        $_SESSION['error'] = 'Please login';
        header('Location: '.$prevUrl);
    }else {
        $token = $_GET['t'];
        include_once 'api/config/database.php';
        include_once 'api/classes/User.php';
        include_once 'api/classes/Student.php';

        $conn = Database::getInstance();

        $user = new User($conn);
        $user->setToken($token);
        $phone = '';
        if ($user->verifyToken()){
            if ($user->getLevel() == 3) {
                $student = new Student($conn);
                $student->setRegNo($user->getUsername());
                $phone = $student->getUser()['phone_no'];
            }
        }else{
            header('Location: confirm-username.php');
            die();
        }
    }
    ?>

    <!-- preloader -->
    <div class="la-anim-1"></div>

    <div class="account-pages mt-3 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary">
                            <div class="text-primary text-center p-4">
                                <h5 class="text-white font-size-20">Set Password</h5>
                                <p class="text-white-50">Hello <?= $user->getUsername() ?>, enter your new password!</p>
                                <a href="javascript:void(0)" class="logo logo-admin">
                                    <img src="assets/images/users/user-6.jpg" class="rounded-circle" height="70" alt="logo">
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="p-3">
                                <form class="form-horizontal mt-3 password-form">

                                    <div class="form-group">
                                        <label for="otp">OTP Code</label>
                                        <input type="text" class="form-control" id="otp" name="otp"placeholder="Enter the code sent to your phone number">
                                        <div class="text-right">
                                            <a href="javascript:void(0)" class="text-underline" onclick="sendMsg()">resend code</a>
                                        </div>
                                    </div>

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
                                            <button class="btn btn-primary w-md waves-effect waves-light p-b-8 p-t-8" type="submit" id="btn-save">Save Password</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="mt-3 text-center">
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
    <script type="text/javascript" src="assets/libs/lobibox/js/lobibox.min.js"></script>
    <script src="assets/js/app.js"></script>

</body>

</html>
<script type="text/javascript">
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
            Lobibox.notify('success', {
                position: 'top right',
                // delayIndicator: false,
                icon: 'fa fa-check',
                msg: 'Your code was successfully sent to <?php echo $phone ?>'
            });
        }, 1800);
    }

    function sendMsg(){
            $('#btn-save').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...')

                $name = '<?= $user->getUsername() ?>'
                $.post('api/signup/', {name: $name}, function(data, textStatus, xhr) {
                    console.log(data);
                    if (typeof data['success']['message'] != 'undefined') {
                        let token = data['success']['message']
                        if (token != '') {
                            Lobibox.notify('success', {
                                position: 'top right',
                                // delayIndicator: false,
                                icon: 'fa fa-check',
                                msg: 'Your code was successfully sent to your phone number and email'
                            });
                        }
                    }
                }).fail(function(data){
                    console.log(data);
                    let message = typeof data['responseJSON']['error']['message'] != 'undefined'? data['responseJSON']['error']['message'] : 'Some unexpected error occured';
                    Swal.fire({ 
                        title: "Sorry!",
                        text: message,
                        showClass: {popup: 'animated fadeInDown faster'},
                        hideClass: {popup: 'animated fadeOutUp faster'},
                        icon: "error",
                        confirmButtonColor: "#025", 
                      })
                }).always(()=>{
                    $('#btn-save').prop('disabled', false).html('Save Password')
                });
        }

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
                'otp':{
                    excluded: 'false',
                    validators:{
                        notEmpty: {
                            message: 'Please provide a code sent to your phone.'
                        }
                    }
                },
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
                        notEmpty: {
                            message: 'Please provide a password to login.'
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
                $('#btn-save').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...')

                $form = $(e.target);
                $pass = $.trim($('input[name="password"]').val())
                $otp = $.trim($('input[name="otp"]').val())
                $token = '<?php echo $token ?>';
                $.post('api/ResetPassword/', {token: $token,otp: $otp,password: $pass}, function(data, textStatus, xhr) {
                    if (typeof data.success.message != 'undefined') {
                        Lobibox.notify('success', {
                            position: 'top right',
                            // delayIndicator: false,
                            icon: 'fa fa-check',
                            msg: data.success.message
                        });
                        }
                }).fail(function(data){
                    console.log(data);
                    let message = typeof data['responseJSON']['error']['message'] != 'undefined'? data['responseJSON']['error']['message'] : 'Some unexpected error occured';
                    Lobibox.notify('error', {
                            position: 'top right',
                            // delayIndicator: false,
                            icon: 'fa fa-times',
                            msg: message
                        });
                }).always(()=>{$('#btn-save').prop('disabled', false).html('Save Password')});
                $form
                    .bootstrapValidator('disableSubmitButtons', false)
                    .bootstrapValidator('resetForm', true);
            }
        }).on('status.field.bv', function(e, data) {
              data.bv.disableSubmitButtons(false);
            });
    });
</script>