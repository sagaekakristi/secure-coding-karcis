<?php
include "../conn.php";
include "valid.php";

@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
    exit;
}

$csrf_token = $_POST['csrf_token'];

if (!isset($_SESSION['profile_csrf_token']) || $_SESSION['profile_csrf_token'] != $csrf_token) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Form tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

$fullname = @$_POST['fullname'];

if (!isset($fullname)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nama harus diisi!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

if (valid_name($fullname) === FALSE) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nama tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

$email = @$_POST['email'];

if (!isset($email)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Email harus diisi!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

if (valid_email($email) === FALSE) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Email tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

$phone = @$_POST['phone'];

if (!isset($phone)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nomor telepon harus diisi!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

if (valid_number($phone) === FALSE) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nomor handphone tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

// file
$file = $_FILES['userfile'];

if (!isset($file)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Identitas belum diunggah!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

$fileName = $file['name'];

if (valid_filename($fileName)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nama file tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

if (valid_file($file, 'jpg', 'image/jpeg') === FALSE && valid_file($file, 'jpeg', 'image/jpeg') === FALSE && valid_file($file, 'png', 'image/png')) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Tipe file tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    exit;
}

 // nama direktori upload
$namaDir = '../files/';

// membuat path nama direktori + nama file.
$pathFile = $namaDir.$fileName;

// memindahkan file ke temporary
$tmpName  = $file['tmp_name'];

// proses upload file dari temporary ke path file
if (move_uploaded_file($file['tmp_name'], $pathFile)) {
    // save user account
    $sql = "UPDATE users SET email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $id);
    $stmt->execute();

    $is_users_updated = $stmt->affected_rows == 1;

    if(!$is_users_updated){
        $_SESSION['profile_submit'] = true;
        $_SESSION['profile_success'] = false;
        $_SESSION['profile_message'] = 'Tidak dapat menyimpan akun user!';

        header('Location: '.$host.'editProfile.php' );
        exit;
    }

    $sql = "UPDATE user_profile SET fullname = ?, phone = ?, identity_card = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $fullname, $phone, $fileName, $id_user);
    $stmt->execute();

    $is_user_profile_updated = $stmt->affected_rows == 1;

    if(!$is_users_profile_updated){
        $_SESSION['profile_submit'] = true;
        $_SESSION['profile_success'] = false;
        $_SESSION['profile_message'] = 'Tidak dapat menyimpan profile user!';

        header('Location: '.$host.'editProfile.php' );
        exit;
    }

    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = true;
    $_SESSION['profile_message'] = 'Profil berhasil disimpan!';

    header('Location: '.$host.'profile.php');
    exit;
} else {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Tidak dapat menyimpan file!';

    header('Location: '.$host.'editProfile.php' );
}


