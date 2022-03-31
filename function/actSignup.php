<?php
    include "../conn.php";

    $fullname = strip_tags(@$_POST['fullname']);
    $email    = htmlentities(@$_POST['email'], ENT_QUOTES);
    $password = hash("sha512", $email . htmlentities(@$_POST['password'], ENT_QUOTES));

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


?>
