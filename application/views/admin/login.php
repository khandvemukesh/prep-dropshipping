<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ax-xpress | Admin LOGIN</title>
    <?php include('php-assets/head-section.php') ?>
</head>

<body class="hold-transition login-page" style="background-image: url('<?php echo base_url() ?>image/loginbg4.jpg');background-repeat: no-repeat;background-attachment: fixed; background-position: left;background-color: #ffffff; background-size: cover;">
    <div class="login-box">
        <div class="card card-outline card-primary" style="background:#fff;">
            <div class="card-header text-center">
                <div>
                    <img src="<?php echo base_url() ?>image/logo.png" class="img img-responsive" style="width:70%;">
                </div>
                <div>
                    <a href="<?php echo base_url() ?>" class="h5 text-white pt-1">Admin/Staff Login</a>
                </div>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="loginForm" method="post">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="emailMessage">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" name="email" id="email" onblur="checkDetailsLogin('email','emailMessage');" placeholder="Email/Username">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="passwordMessage">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" onblur="checkDetailsLogin('password','passwordMessage');">
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="<?php echo base_url(); ?>main/forgetPassword" class="text-danger">I forgot my password</a>
                </p>
            </div>
        </div>
    </div>

    <?php include('php-assets/foot-section.php') ?>

    <script>
        $(document).on("submit", "#loginForm", function(e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/checkLoginDetails",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                success: function(data) {
                    if (data == true) {
                        showMessage('Logged In', 'Good Job Logged In Successfully', 'success');
                        setTimeout(function() {
                            window.location.href = "<?php echo base_url() ?>admin-dashboard";
                        }, 2000);
                    } else {
                        toastFire('error', 'Incorrect Credentials', 'top-end', '#dc3545d9', '#fff');
                    }
                }
            })
        })
    </script>
</body>

</html>