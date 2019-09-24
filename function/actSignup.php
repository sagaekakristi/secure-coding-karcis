<?php

include "../conn.php";
include "./valid.php";
@session_start();

$csrf_token = $_POST['csrf_token'];

if (!isset($_SESSION['signup_csrf_token']) || $_SESSION['signup_csrf_token'] != $csrf_token) {
    $_SESSION['signup_submit'] = true;
    $_SESSION['signup_success'] = false;
    $_SESSION['signup_message'] = 'Form tidak valid!';

    header('Location: '.$host.'signup.php' );
    exit;
}

$email = @$_POST['email'];

if (valid_email($email) === FALSE) {
    $_SESSION['signin_submit'] = true;
    $_SESSION['signin_success'] = false;
    $_SESSION['signin_message'] = 'Email tidak valid!';

    header('Location: '.$host.'signup.php' );
    exit;
}

$fullname = @$_POST['fullname'];

if (valid_name($fullname) === FALSE) {
    $_SESSION['signin_submit'] = true;
    $_SESSION['signin_success'] = false;
    $_SESSION['signin_message'] = 'Nama tidak valid!';

    header('Location: '.$host.'signup.php' );
}

$password = @$_POST['password'];
$password_confirm = @$_POST['password_confirm'];

// validate password strength
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);

if (valid_password($password) === FALSE) {
    $_SESSION['signup_submit'] = true;
    $_SESSION['signup_success'] = false;
    $_SESSION['signup_message'] = 'Password kurang aman, minimal 8 karakter, kombinasi huruf besar, huruf kecil, dan angka!';

    header('Location: '.$host.'signup.php' );      
    exit;
}

// validate password and password confirm
$password_encrypt = sha1($password);
$password_confirm_encrypt = sha1($password_confirm);

if ($password_encrypt != $password_confirm_encrypt) {
    $_SESSION['signup_submit'] = true;
    $_SESSION['signup_success'] = false;
    $_SESSION['signup_message'] = 'Konfirmasi password tidak sesuai!';

    header('location:'.$host.'signup.php');
    exit;
}

// check if email exist
$sql = "SELECT * FROM users where email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $conn->close();

    $_SESSION['signin_submit'] = true;
    $_SESSION['signin_success'] = true;
    $_SESSION['signin_message'] = 'Email sudah terdaftar! Silahkan login!';

    header('location:'.$host.'signin.php');
    exit;
}

// save user account
$sql = "INSERT INTO users (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $email, $password_encrypt);
$stmt->execute();

$is_inserted = $stmt->affected_rows == 1;

if (!$is_inserted === TRUE) {
    $conn->close();

    $_SESSION['signup_submit'] = true;
    $_SESSION['signup_success'] = false;
    $_SESSION['signup_message'] = 'Tidak dapat melakukan registrasi!';

    header('location:'.$host.'signup.php');
    exit;
}

$id_user = $stmt->insert_id;

// save user profile
$sql = "INSERT INTO user_profile (id_user, fullname) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $id_user, $fullname);
$stmt->execute();
$conn->close();

if(!$is_inserted === TRUE){
    $_SESSION['signup_submit'] = true;
    $_SESSION['signup_success'] = false;
    $_SESSION['signup_message'] = 'Tidak dapat melakukan registrasi profil!';

    header('location:'.$host.'signup.php');
    exit;
}

$_SESSION['signin_submit'] = true;
$_SESSION['signin_success'] = true;
$_SESSION['signin_message'] = 'Registrasi berhasil! Silahkan login!';

header('location:'.$host.'signin.php');
exit;
