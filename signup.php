<?php
include "header.php";
@session_start();

$csrf_token = sha1(uniqid('', TRUE));
$_SESSION['signup_csrf_token'] = $csrf_token;
?>

<div class="login-clean">
        <form method="post" action="<?php echo $host;?>function/actSignup.php">
            <h2 class="sr-only">Login Form</h2>
            <!-- if signup failed -->
            <?php
                $submit  = $_SESSION['signup_submit'] ?? false;
                $success = $_SESSION['signup_success'] ?? false;
                $message = $_SESSION['signup_message'] ?? '';

                unset($_SESSION['signup_submit']);
                unset($_SESSION['signup_error']);
                unset($_SESSION['signup_message']);
                
                if(isset($submit) && $success){
            ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } else if(isset($submit) && !$success) { ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } ?>

            <!--  -->
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
            <div class="illustration"><i class="fa fa-ticket"></i></div>
            <div class="form-group"><input class="form-control" type="text" name="fullname" placeholder="Nama Lengkap"></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><input class="form-control" type="password" name="password_confirm" placeholder="Konfirmasi Password"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Sign Up</button></div><a class="forgot" href="forgotPassword.php">Forgot your password?</a></form>
    </div>
    
<?php
include "footer.php";
?>