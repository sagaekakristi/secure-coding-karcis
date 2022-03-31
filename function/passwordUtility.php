<?php

function check_password_strength($pwd){
    $error = '';

    if (strlen($pwd) < 8) {
        $error .= "Password length must be >= 8<br>";
    }

    if (strlen($pwd) > 250) {
        $error .= "Password length must be <= 250<br>"; // to prevent password too big for database
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $error .= "Password must include at least one number!<br>";
    }

    if( !preg_match("#[a-z]+#", $pwd) ) {
        $error .= "Password must include at least one lowercase letter!<br>";
    }

    if( !preg_match("#[A-Z]+#", $pwd) ) {
        $error .= "Password must include at least one uppercase letter!<br>";
    }

    if( !preg_match("#\W+#", $pwd) ) {
        $error .= "Password must include at least one symbol!<br>";
    }

    return $error;

}

?>
