<?php
include "header.php";
include "function/getMyBooking.php";

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
}
?>

<div class="booking-body">
    <?php
        $submit = $_SESSION['booking_submit'] ?? false;
        $success = $_SESSION['booking_success'] ?? false;
        $message = $_SESSION['booking_message'] ?? '';

        unset($_SESSION['booking_submit']);
        unset($_SESSION['booking_error']);
        unset($_SESSION['booking_message']);
        if(isset($submit) && $success){
    ?>
        <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
    <?php } else if(isset($submit) && !$success) { ?>
        <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
    <?php } ?>

    <div class="booking-card pb-1">
        <h4 class="mb-4">My Bookings</h4>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
            <div class="row pl-0 pr-0 pt-3 pb-3 ml-1 mr-1 booking-line">
                <div class="col-md-1 p-0 m-0">
                    <img class="booking-img-ticket-item" src="assets/img/ticket-item.png" alt=""/>
                </div>
                <div class="col-md-2">
                    <p class="booking-font-field-title">ID Booking</p>
                    <p class="booking-font-field"><?php echo $row['id_booking'];?></p>
                </div>
                <div class="col-md-6">
                    <p class="booking-font-field-title">Destination</p>
                    <p class="booking-font-field"><?php echo $row['from'];?> - <?php echo $row['to'];?></p>
                </div>
                <div class="col-md-3 p-0 m-0 text-right">
                    <a href="<?php echo $host;?>myBookingDetail.php?IDBOOKING=<?php echo $row['id_booking'];?>">
                        <button class="btn btn-booking-primary p-0 m-0" type="submit">Detail</button>
                    </a>
                </div>
            </div>
        <?php } } ?>

    </div>

</div>

<?php
include "footer.php";
?>