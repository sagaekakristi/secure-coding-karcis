<?php
include "header.php";
@session_start();

$csrf_token = sha1(uniqid('', TRUE));
$_SESSION['forgotPassword_csrf_token'] = $csrf_token;
?>

<div class="login-clean">
        <form method="post" action="<?php echo $host;?>function/actForgotPassword.php">
             <!-- if signup failed -->
             <?php
                $submit = $_SESSION['forgotPassword_submit'] ?? false;
                $success = $_SESSION['forgotPassword_success'] ?? false;
                $message = $_SESSION['forgotPassword_message'] ?? '';

                unset($_SESSION['forgotPassword_submit']);
                unset($_SESSION['forgotPassword_error']);
                unset($_SESSION['forgotPassword_message']);
                if(isset($submit) && $success){
            ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } else if(isset($submit) && !$success) { ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } ?>
            <!--  -->

            <h2 class="sr-only">Forgot Password</h2>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
            <div class="illustration"><i class="fa fa-ticket"></i></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Reset Password</button></div><a class="forgot" href="signin.php">Already Have an Account?</a></form>
</div>

<?php
include "footer.php";
?>