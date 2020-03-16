<?php include_once 'head.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-validator/css/bootstrapValidator.css">
<link rel="stylesheet" type="text/css" href="assets/libs/sweetalert2/sweetalert2.min.css">
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

	<div class="account-pages my-5 pt-5">
	    <div class="container">
	        <div class="row justify-content-center">
	            <div class="col-md-8 col-lg-6 col-xl-5">
	                <div class="card overflow-hidden">
	                    <div class="bg-primary">
	                        <div class="text-primary text-center p-4">
	                            <h5 class="text-white font-size-20 p-2">Confirm Username</h5>
	                            <a href="index.html" class="logo logo-admin">
	                                <img src="assets/images/logo-sm.png" height="70" alt="logo">
	                            </a>
	                        </div>
	                    </div>

	                    <div class="card-body p-4">
	                        
	                        <div class="p-3">

	                            <div class="alert alert-success mt-4" role="alert">
	                                Enter your username to continue (Registration number or employee id).
	                            </div>


	                            <form class="form-horizontal mt-4 signup-form">

	                                <div class="form-group">
	                                    <label for="useremail">Username</label>
	                                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
	                                </div>
	        
	                                <div class="form-group row  mb-0">
	                                    <div class="col-12 text-right">
	                                        <button class="btn btn-primary w-md waves-effect waves-light p-b-8 p-t-8" id="btn-cont" type="submit">Continue</button>
	                                    </div>
	                                </div>

	                            </form>

	                        </div>
	                    </div>

	                </div>

	                <div class="mt-5 text-center">
	                    <p>Have an account ? <a href="index.php" class="font-weight-medium text-primary"> Sign In here </a> </p>
	                    <p class="mb-0 text-success">© <script>document.write(new Date().getFullYear())</script> FYPMS.
	                </div>

	            </div>
	        </div>
	    </div>
	</div>
</body>
</html>
<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="assets/libs/bootstrap-validator/js/bootstrapValidator.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script type="text/javascript" src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script src="assets/js/app.js"></script>
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
        }, 1800);
    }

	$(document).ready(function() {
        $('.signup-form').on('submit', function(event) {
            event.preventDefault();
        });

        $('.signup-form').bootstrapValidator({
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
                }            },
            onSuccess: function (e,data) {

                $('#btn-cont').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...')

                $form = $(e.target);
                $name = $.trim($('input[name="username"]').val())
                $.post('api/signup/', {name: $name}, function(data, textStatus, xhr) {
                    if (typeof data['success']['message'] != 'undefined') {
                        let token = data['success']['message']
                        location.href = `reset-password.php?t=${token}`
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
                    $('#btn-cont').prop('disabled', false).html('Continue')
                });


	            $form
	                .bootstrapValidator('disableSubmitButtons', false)
	                .bootstrapValidator('resetForm', true);
            }
        }).on('status.field.bv', function(e, data) {
          data.bv.disableSubmitButtons(false);
        });
    });
</script>