<?php
include "header.php";

unset($_SESSION['forgotPassword_submit']);
unset($_SESSION['forgotPassword_success']);
unset($_SESSION['forgotPassword_message']);

$hash = @$_GET['hash'];

$reset_password = "SELECT link FROM forgot_password WHERE hash = '$hash'";

$sql = "SELECT link FROM forgot_password WHERE hash = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $hash);
$stmt->execute();
$result = $stmt->get_result();

$r_reset_password = mysqli_fetch_row($result);

?>

<div class="login-clean">
<?php if($r_reset_password) { ?>
            <h2 class="sr-only">Reset Password</h2>

            <div class="form-group">
                <a href="http://<?php echo $r_reset_password[0]; ?>">
                    <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                </a>
            </div>

            
            <?php } else {
                echo "Data Not Found, <a href=login.php>Login</a>";
                
            } ?>
</div>
<?php
include "footer.php";
?>