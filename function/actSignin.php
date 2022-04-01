<?php

    include "../conn.php";

    session_start();
    $vercode_form = @$_POST["vercode"];
    $vercode_session = @$_SESSION["vercode"];
    if ($vercode_form != $vercode_session) {
        echo "<script>alert('Incorrect verification code');</script>" ;
    }
    else {
        $email = htmlentities(@$_POST['email'], ENT_QUOTES);
        $password = hash("sha512", $email . htmlentities(@$_POST['password'], ENT_QUOTES));

        $sql = "SELECT * FROM users where email = '$email' and password = '$password'";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                session_start();
                @$_SESSION["id"] = $row['id'];
                @$_SESSION["fullname"] = $row['fullname'];
                @$_SESSION['tipe'] = 'users';

                header('Location: '.$host.'profile.php');
            }
        } else {
            header('Location: '.$host.'signin.php?status=failed' );
        }
        $conn->close();
    }

?>