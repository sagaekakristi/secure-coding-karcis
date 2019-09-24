<?php

include "conn.php";
@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
    exit;
}

$submit = false;
$success = false;
$message = "";

// get data user
$sql = "SELECT tickets.*, booking.id as id_booking FROM booking 
    LEFT JOIN tickets ON tickets.id = booking.id_ticket WHERE booking.id_user = ?
    ORDER BY booking.created_at DESC ";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    $submit = true;
    $success = false;
    $message = "Tiket tidak ditemukan!";
} else {
    $submit = true;
    $success = true;
}