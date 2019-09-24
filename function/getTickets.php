<?php
@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
    exit;
}

$sql = "SELECT t.from, t.to, t.price, t.seats FROM tickets t where seats > 0";
$result = $conn->query($sql);
