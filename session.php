<?php
    if (empty($_SESSION['token'])) {
        // $_SESSION['token'] = bin2hex(random_bytes(32));
        $_SESSION['token'] = md5(uniqid(rand(), TRUE));
    }
    $token = $_SESSION['token'];

function check_token() {
    if (!empty($_POST['token'])) {
        if (hash_equals($_SESSION['token'], $_POST['token'])) {
             // Proceed to process the form data
             unset($_SESSION['token']);
             return true;
        } else {
             // Log this as a warning and keep an eye on these attempts
             return false;
        }
    }
}