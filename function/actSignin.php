<?php
    include "../conn.php";

    $email = htmlentities(@$_POST['email']);
    $password = sha1(htmlentities(@$_POST['password']));

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


?>