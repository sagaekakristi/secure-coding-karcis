<?php
include "../conn.php";
include "valid.php";

@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
}

$csrf_token = $_POST['csrf_token'];

if (!isset($_SESSION['profile_csrf_token']) || $_SESSION['profile_csrf_token'] != $csrf_token) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Form tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    return;
}

$fullname = @$_POST['fullname'];

if (!isset($fullname)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nama harus diisi!';

    header('Location: '.$host.'editProfile.php' );
    return;
}

if (valid_name($fullname) === FALSE) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nama tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    return;
}

$email = @$_POST['email'];

if (!isset($email)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Email harus diisi!';

    header('Location: '.$host.'editProfile.php' );
    return;
}

if (valid_email($email) === FALSE) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Email tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    return;
}

$phone = @$_POST['phone'];

if (!isset($phone)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nomor telepon harus diisi!';

    header('Location: '.$host.'editProfile.php' );
    return;
}

if (valid_number($phone) === FALSE) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nomor handphone tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    return;
}

// file
$file = $_FILES['userfile'];

if (!isset($file)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Identitas belum diunggah!';

    header('Location: '.$host.'editProfile.php' );
    return;
}

$fileName = $file['name'];

if (valid_filename($fileName)) {
    $_SESSION['profile_submit'] = true;
    $_SESSION['profile_success'] = false;
    $_SESSION['profile_message'] = 'Nama file tidak valid!';

    header('Location: '.$host.'editProfile.php' );
    return;
}

if (valid_file($file, 'jpg', 'image/jpeg') === FALSE && valid_file($file, 'jpeg', 'image/jpeg') === FALSE && valid_file($file, 'png', 'image/png')) {
    // TODO do something here
}

 // nama direktori upload
$namaDir = '../files/';

// membuat path nama direktori + nama file.
$pathFile = $namaDir.$fileName;

if ($fileName) {
    // memindahkan file ke temporary
    $tmpName  = $file['tmp_name'];

    // proses upload file dari temporary ke path file
    if (move_uploaded_file($file['tmp_name'], $pathFile)) {
        // update data
        $user = "UPDATE users SET email = '$email' WHERE id = $id";
        $conn->query($user);

        $userProfile = "UPDATE user_profile SET fullname = '$fullname', phone = '$phone', identity_card = '$fileName' WHERE id_user = $id";
        $conn->query($userProfile);

        if($conn->query($user) === FALSE && $conn->query($userProfile) === FALSE){
            echo("Error description: " . mysqli_error($conn));
        }

        header('Location: '.$host.'profile.php');
    } else {
        var_dump($file['error']);
        echo "File gagal diupload.";
    }
} else {
    // update data
    $user = "UPDATE users SET email = '$email' WHERE id = $id";
    $conn->query($user);

    $userProfile = "UPDATE user_profile SET fullname = '$fullname', phone = '$phone' WHERE id_user = $id";
    $conn->query($userProfile);

    if($conn->query($user) === FALSE && $conn->query($userProfile) === FALSE){
        echo("Error description: " . mysqli_error($conn));
    }

    header('Location: '.$host.'profile.php?status=success');
}


