<?php

include "../conn.php";
include "./valid.php";
@session_start();

$csrf_token = $_POST['csrf_token'];

if (!isset($_SESSION['signin_csrf_token']) || $_SESSION['signin_csrf_token'] != $csrf_token) {
    $_SESSION['signin_submit'] = true;
    $_SESSION['signin_success'] = false;
    $_SESSION['signin_message'] = 'Form tidak valid!';

    header('Location: '.$host.'signin.php' );
    return;
}

$email = @$_POST['email'];

if (valid_email($email) === FALSE) {
    $_SESSION['signin_submit'] = true;
    $_SESSION['signin_success'] = false;
    $_SESSION['signin_message'] = 'Format email tidak valid!';

    header('Location: '.$host.'signin.php' );
    return;
}

$password = @$_POST['password'];

if (valid_password($password) === FALSE) {
    $_SESSION['signin_submit'] = true;
    $_SESSION['signin_success'] = false;
    $_SESSION['signin_message'] = 'Format password tidak valid!';

    header('Location: '.$host.'signin.php' );
    return;
}

$password_encrypt = sha1(@$_POST['password']);

$sql = "SELECT * FROM users where email = ? and password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $email, $password_encrypt);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        @$_SESSION["id"] = $row['id'];
        @$_SESSION["fullname"] = $row['fullname'];
        @$_SESSION['tipe'] = 'users';
    }

    unset($_SESSION['signin_submit']);
    unset($_SESSION['signin_success']);
    unset($_SESSION['signin_message']);
    
    // revalidate back history
    header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
    header('Pragma', 'no-cache');
    header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

    header('Location: '.$host.'profile.php');
} else {
    $_SESSION['signin_submit'] = true;
    $_SESSION['signin_success'] = true;
    $_SESSION['signin_message'] = 'Email dan Password tidak sesuai';

    header('Location: '.$host.'signin.php' );
}

$conn->close();

