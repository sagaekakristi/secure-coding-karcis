<?php
@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
    return;
}

$sql = "SELECT * FROM tickets";
$result = $conn->query($sql);
