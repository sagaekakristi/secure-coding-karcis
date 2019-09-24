<?php
include "header.php";
include "function/searchBooking.php";

?>

<div class="container profile profile-view">
        <div class="row">
            <div class="col-md-12 alert-col relative">
            <?php
                if(isset($submit) && $success){
            ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } else if(isset($submit) && !$success) { ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } ?>
            </div>
        </div>
        <?php
            if (isset($submit) && $success) {
        ?>
            <div class="row space-rows">
                <?php
                    $no = 1;
                    if ($result->num_rows > 0) {
                    // output data of each row
                        while($row = $result->fetch_assoc()) {

                ?>
                <div class="col-md-4 mb-4">
                        <div class="card cards-shadown cards-hover">
                            <div class="card-body">
                                <p class="card-text cardbody-sub-text" style="float: left;font-size: 18px;">
                                    Nama: <?php echo $row['fullname'];?>
                                </p>
                            </div>
                            
                            <div class="card-header">
                                
                                <div class="cardheader-text">
                                    <h4 id="heading-card"><?php echo $row['from']." ".$row['to'];?></h4>
                                    <p class="sub-text-color">Status: Belum Dibayar</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text cardbody-sub-text">Rp<?php echo number_format($row['booking_price'],2,',','.'); ?></p>
                            </div>

                        </div>
                </div>
                <?php $no++; }  } ?>
              
            </div>
       <?php } ?>
</div>

<?php include "footer.php";?>