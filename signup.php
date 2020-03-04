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
	                            <h5 class="text-white font-size-20 p-2">Signup</h5>
	                            <a href="index.html" class="logo logo-admin">
	                                <img src="assets/images/logo-sm.png" height="70" alt="logo">
	                            </a>
	                        </div>
	                    </div>

	                    <div class="card-body p-4">
	                        
	                        <div class="p-3">

	                            <div class="alert alert-success mt-5" role="alert">
	                                Enter your username to continue (Registration number or employee id).
	                            </div>


	                            <form class="form-horizontal mt-4 signup-form">

	                                <div class="form-group">
	                                    <label for="useremail">Username</label>
	                                    <input type="email" class="form-control" id="username" placeholder="Enter username" name="username">
	                                </div>
	        
	                                <div class="form-group row  mb-0">
	                                    <div class="col-12 text-right">
	                                        <button class="btn btn-primary w-md waves-effect waves-light p-b-8 p-t-8" type="submit">Continue</button>
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

<script src="assets/js/app.js"></script>
<script type="text/javascript">
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
            onSuccess: function (data) {
                alert("message");
            }
        });
    }).on('status.field.bv', function(e, data) {
      data.bv.disableSubmitButtons(false);
    });
</script>