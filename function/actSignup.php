<?php
    include "../conn.php";
    include "passwordUtility.php";

    session_start();
    $vercode_form = @$_POST["vercode"];
    $vercode_session = @$_SESSION["vercode"];
    if ($vercode_form != $vercode_session) {
        echo "<script>alert('Incorrect verification code');</script>" ;
    }
    else {
        $fullname = strip_tags(@$_POST['fullname']);
        $email    = htmlentities(@$_POST['email'], ENT_QUOTES);

        $raw_password = @$_POST['password'];

        $validation_result = check_password_strength($raw_password);
        if (strcmp($validation_result, "") !== 0) {
            echo($validation_result);
        }
        else {
            $password = hash("sha512", $email . htmlentities($raw_password, ENT_QUOTES));

            // insert to database
            $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                $sql_profile = "INSERT INTO user_profile (id_user,fullname) VALUES ('$conn->insert_id','$fullname')";
                if($conn->query($sql_profile) === TRUE){
                    
                    header('location:'.$host.'signin.php?status=success');
                } else {;
                    echo("Error description: " . mysqli_error($conn));
                }  
            } 
        }
    }

        

?>
