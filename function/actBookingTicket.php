<?php

include "../conn.php";
include "valid.php";
@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
    exit;
}

// check ticket
$id_ticket = @$_POST['id_ticket'];

if (valid_number($id_ticket) === FALSE) {
    $conn->close();

    $_SESSION['ticket_submit'] = true;
    $_SESSION['ticket_success'] = false;
    $_SESSION['ticket_message'] = 'Tiket tidak ditemukan!';

    header('location:'.$host.'tickets.php');
    exit;
}

$sql = "SELECT * FROM tickets where id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $id_ticket);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    $conn->close();

    $_SESSION['ticket_submit'] = true;
    $_SESSION['ticket_success'] = false;
    $_SESSION['ticket_message'] = 'Tiket tidak ditemukan!';

    header('location:'.$host.'tickets.php');
    exit;
}

$ticket = $result->fetch_assoc();

$percent = 10;

$percentInDecimal = $percent / 100;

//Get the result.
$percent = $percentInDecimal * $ticket['price'];

$total_price = $ticket['price'] + $percent;

// jika kursi 0
if($ticket['seats'] < 1){
    $conn->close();

    $_SESSION['ticket_submit'] = true;
    $_SESSION['ticket_success'] = false;
    $_SESSION['ticket_message'] = 'Tiket sudah habis!';

    header('location:'.$host.'tickets.php');
    exit;
}


// insert table booking
$sql = "INSERT INTO booking (id_user, id_ticket, status, price) VALUES (?, ?, 0, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sid', $id, $id_ticket, $total_price);
$stmt->execute();

if ($stmt->affected_rows <= 0) {
    $conn->close();

    $_SESSION['ticket_submit'] = true;
    $_SESSION['ticket_success'] = false;
    $_SESSION['ticket_message'] = 'Tidak dapat menyimpan booking!';

    header('location:'.$host.'tickets.php');
    exit;
}


// update seats in table tickets
$sql_update = "UPDATE tickets SET seats = seats - 1 WHERE id = $id_ticket";

$sql = "UPDATE tickets SET seats = seats - 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $id_ticket);
$stmt->execute();

if ($stmt->affected_rows <= 0) {
    $conn->close();

    $_SESSION['ticket_submit'] = true;
    $_SESSION['ticket_success'] = false;
    $_SESSION['ticket_message'] = 'Tidak dapat menyimpan ticket!';

    header('location:'.$host.'tickets.php');
    exit;
}

$_SESSION['booking_submit'] = true;
$_SESSION['booking_success'] = true;
$_SESSION['booking_message'] = 'Booking berhasil disimpan!';

header('Location: '.$host.'myBookings.php');
exit;