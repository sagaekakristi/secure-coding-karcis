<?php
include "../conn.php";

@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
}

$result = $conn->query("SELECT `email` from users WHERE id = $id");
$row = $result->fetch_assoc();
$email = $row['email'];
$password = hash("sha512", $email . htmlentities(@$_POST['password'], ENT_QUOTES));

// update data
$user = "UPDATE users SET password = '$password' WHERE id = $id";
$conn->query($user);


if($conn->query($user) === FALSE){
    echo("Error description: " . mysqli_error($conn));
}

header('Location: '.$host.'changePassword.php?status=success');


