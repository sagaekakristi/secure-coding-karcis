<?php
include "../conn.php";

$token = @$_POST['token'];
$email = @$_POST['email'];
$password = hash("sha512", $email . htmlentities(@$_POST['password'], ENT_QUOTES));

$sql = "SELECT * FROM forgot_password where email = '$email' and hash = '$token' and flag = 0";
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $u_user = "UPDATE users SET password = '$password' WHERE email = '$email'";
            $conn->query($u_user);

            header('Location: '.$host.'signin.php?status=success&m=newPassword');
        }
    } else{
        header('Location: '.$host.'signin.php?status=failed');
    }

?>