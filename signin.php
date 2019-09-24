<?php
include "header.php";

@session_start();
$csrf_token = sha1(uniqid('', TRUE));
$_SESSION['signin_csrf_token'] = $csrf_token;

?>

<div class="login-clean">
        <form method="post" action="<?php echo $host;?>function/actSignin.php">
             <!-- if signup failed -->
             <?php
                $submit = $_SESSION['signin_submit'] ?? false;
                $success = $_SESSION['signin_success'] ?? false;
                $message = $_SESSION['signin_message'] ?? '';

                unset($_SESSION['signin_submit']);
                unset($_SESSION['signin_error']);
                unset($_SESSION['signin_message']);
                if(isset($submit) && $success){
            ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } else if(isset($submit) && !$success) { ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } ?>
            <!--  -->

            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="fa fa-ticket"></i></div>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Sign In</button></div><a class="forgot" href="forgotPassword.php">Forgot your password?</a></form>
</div>

<?php
include "footer.php";
?>