<?php
include "header.php";
include "function/getTickets.php";

@session_start();
$csrf_token = sha1(uniqid('', TRUE));
$_SESSION['ticket_csrf_token'] = $csrf_token;
?>

<div class="container profile profile-view">
        <div class="row">
            <div class="col-md-12 alert-col relative">
                <!-- if ticket failed -->
                <?php
                    $submit = $_SESSION['ticket_submit'] ?? false;
                    $success = $_SESSION['ticket_success'] ?? false;
                    $message = $_SESSION['ticket_message'] ?? '';

                    unset($_SESSION['ticket_submit']);
                    unset($_SESSION['ticket_error']);
                    unset($_SESSION['ticket_message']);
                    if(isset($submit) && $success){
                ?>
                    <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
                <?php } else if(isset($submit) && !$success) { ?>
                    <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
                <?php } ?>
                <!--  -->
            </div>
        </div>
        <div class="row space-rows">
            <?php
                $no = 1;
                if ($result->num_rows > 0) {
                // output data of each row
                    while($row = $result->fetch_assoc()) {
            ?>
            <div class="col">
                <form action="<?php echo $host;?>function/actBookingTicket.php" method="POST">
                    <div class="card cards-shadown cards-hover">
                        <div class="card-header">
                            <div class="cardheader-text">
                                <h4 id="heading-card" style="color: #ffffff; text-shadow: -1px -1px rgba(0,0,0,0.5);"><?php echo $row['from']." ".$row['to'];?></h4>
                                <p class="sub-text-color">Sisa tempat duduk: <?php echo $row['seats'];?></p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text cardbody-sub-text m-0 p-0" style="font-size: 30px;color: #595959;">Rp<?php echo number_format($row['price'],2,',','.'); ?></p>
                            <p class="m-0 p-0" style="font-size:24px; color:#595959">+ PPn 10%</p>
                        </div>
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
                        <input type="hidden" name="id_ticket" value="<?php echo $row['id'];?>" >
                        <div class="text-center" style="width: 100%;">
                            <button class="btn btn-karcis-primary p-0 mt-4 mb-4"
                                    style="height: 50px; width: 80%;"
                                    type="submit" name="submit">BOOK NOW!</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php $no++; }  } ?>
          
        </div>
       
</div>

<?php include "footer.php";?>
