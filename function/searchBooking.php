<?php

include "conn.php";
include "function/valid.php";

@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
    exit;
}

$submit = false;
$success = false;
$message = "";

$id_booking = @$_GET['IDBOOKING'];

if (isset($id_booking) && valid_number($id_booking) === FALSE) {
    $submit = true;
    $success = false;
    $message = "Id booking tidak sesuai!";
} else if (isset($id_booking)){        
    $sql = "SELECT tickets.from, tickets.to, tickets.price, tickets.seats, booking.id as id_booking, booking.price as booking_price, booking.id_user, user_profile.fullname FROM booking LEFT JOIN user_profile ON user_profile.id_user = booking.id_user LEFT JOIN tickets ON tickets.id = booking.id_ticket  WHERE booking.id = ? and booking.id_user = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $id_booking, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows <= 0) {
        $submit = true;
        $success = false;
        $message = "Booking tidak ditemukan!";
    } else {
        $submit = true;
        $success = true;
    }
}