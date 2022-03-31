<?php
include "../conn.php";
include "passwordUtility.php";

@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
}

$result = $conn->query("SELECT `email` from users WHERE id = $id");
$row = $result->fetch_assoc();
$email = $row['email'];
$raw_password = @$_POST['password'];

$validation_result = check_password_strength($raw_password);
if (strcmp($validation_result, "") !== 0) {
    echo($validation_result);
}
else {
    $password = hash("sha512", $email . htmlentities($raw_password, ENT_QUOTES));

    // update data
    $user = "UPDATE users SET password = '$password' WHERE id = $id";
    $conn->query($user);


    if($conn->query($user) === FALSE){
        echo("Error description: " . mysqli_error($conn));
    }

    header('Location: '.$host.'changePassword.php?status=success');
}
