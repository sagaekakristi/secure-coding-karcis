<?php

include "../conn.php";
include "./valid.php";
@session_start();

$csrf_token = $_POST['csrf_token'];

if (!isset($_SESSION['forgotPassword_csrf_token']) || $_SESSION['forgotPassword_csrf_token'] != $csrf_token) {
    $_SESSION['forgotPassword_submit'] = true;
    $_SESSION['forgotPassword_success'] = false;
    $_SESSION['forgotPassword_message'] = 'Form tidak valid!';

    header('Location: '.$host.'forgotPassword.php' );
    return;
}

$email = @$_POST['email'];

if (valid_email($email) === FALSE) {
    $_SESSION['forgotPassword_submit'] = true;
    $_SESSION['forgotPassword_success'] = false;
    $_SESSION['forgotPassword_message'] = 'Format email tidak valid!';

    header('Location: '.$host.'forgotPassword.php' );
    return;
}

$hash = sha1($email . uniqid('', true));
$link = $_SERVER['HTTP_HOST'].$host."resetPassword.php?hash=".$hash;

// check if email exist
$sql = "SELECT * FROM users where email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    $conn->close();

    $_SESSION['signin_submit'] = false;
    $_SESSION['signin_success'] = true;
    $_SESSION['signin_message'] = 'Email tidak ditemukan! Silahkan login!';

    header('location:'.$host.'forgotPassword.php');
    return;
}

$sql = "INSERT INTO forgot_password (email, hash, link) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $email, $hash, $link);
$stmt->execute();
$conn->close();

$is_inserted = $stmt->affected_rows == 1;

if (!$is_inserted === TRUE) {
    $_SESSION['forgotPassword_submit'] = true;
    $_SESSION['forgotPassword_success'] = false;
    $_SESSION['forgotPassword_message'] = 'Tidak dapat melakukan membuat link!';

    header('location:'.$host.'forgotPassword.php');
    return;
}

$_SESSION['forgotPassword_submit'] = true;
$_SESSION['forgotPassword_success'] = false;
$_SESSION['forgotPassword_message'] = 'Tidak dapat melakukan registrasi!';

header('location:'.$host.'confirmation.php?hash='.$hash);
