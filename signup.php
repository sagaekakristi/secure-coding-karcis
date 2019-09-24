<?php
include "header.php";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6Le5A7oUAAAAANabUaFxH5AD_qwB3WVWnkI4yOyo"></script>
<script>
function onClickSubmit() {

    var fullname = $('#fullname').val();
    var email = $('#email').val();
    var password = $("#password").val();
    grecaptcha.ready(function() {
        grecaptcha.execute('6Le5A7oUAAAAANabUaFxH5AD_qwB3WVWnkI4yOyo', {action: 'signup'})
        .then(function(token) {
            $.post("<?php echo $host;?>function/actSignup.php", {
                fullname: fullname,
                email: email,
                password: password
            }).then(function() {
                console.debug("SUCCESS");
            }).catch(function() {
                console.debug("FAIL");
            })
        });
    });
}
</script>
<div class="login-clean">
        <form>
            <h2 class="sr-only">Login Form</h2>
            <!-- if signup failed -->
            <?php
                if(@$_GET['status'] == 'failed'){
            ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)">Signup Failed</b>
            <?php } ?>
            <!--  -->
            <div class="illustration"><i class="fa fa-ticket"></i></div>
            <div class="form-group"><input class="form-control" type="text" name="fullname" placeholder="Nama Lengkap"></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" onclick="onClickSubmit()" type="submit">Sign Up</button></div><a class="forgot" href="#">Forgot your email or password?</a></form>
    </div>
<?php
include "footer.php";
?>