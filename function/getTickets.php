<?php
@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
    exit;
}

$sql = "SELECT * FROM tickets where seats > 0";
$result = $conn->query($sql);
