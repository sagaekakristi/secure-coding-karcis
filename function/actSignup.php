<?php
    include "../conn.php";

    $fullname = htmlentities(@$_POST['fullname']);
    $email    = htmlentities(@$_POST['email']);
    $password  = sha1(@$_POST['password']);

    if(isset($_POST['g-recaptcha-response'])){
        $captcha=$_POST['g-recaptcha-response'];
    }
    if(!$captcha){
        echo '<h2>Please check the the captcha form.</h2>';
        header('location:'.$host.'signin.php?status=failed');
    }
    $secretKey = '6Lf4A7oUAAAAAL1D57QBp-I1ZupGvi40DJ5BzeiC';
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);

    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);
    // should return JSON with success as true
    if(!$responseKeys["success"]) {
        echo '<h2>Error Capctha</h2>';
        header('location:'.$host.'signin.php?status=failed');
    }

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
