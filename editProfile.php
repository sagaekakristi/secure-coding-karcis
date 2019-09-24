<?php
include "header.php";
include "function/getProfile.php";

@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
    exit;
}

$csrf_token = sha1(uniqid('', TRUE));
$_SESSION['profile_csrf_token'] = $csrf_token;
?>

<div class="profile-body">
    <form action="<?php echo $host;?>function/actUpdateProfile.php" method="post" enctype="multipart/form-data">
        <div class="profile-card">
            <!-- if signup failed -->
             <?php
                $submit = $_SESSION['profile_submit'] ?? false;
                $success = $_SESSION['profile_success'] ?? false;
                $message = $_SESSION['profile_message'] ?? '';

                unset($_SESSION['profile_submit']);
                unset($_SESSION['profile_error']);
                unset($_SESSION['profile_message']);
                if(isset($submit) && $success){
            ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } else if(isset($submit) && !$success) { ?>
                <b style="display: block;position: relative;text-align:center; color: rgb(244,71,107)"><?php echo $message; ?></b>
            <?php } ?>
            <!--  -->
            <h4>Edit Profile</h4>
            <hr class="profile-line"/>
            <div class="form-row mx-auto pb-4">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
                <div class="form-group" style="width: 100%">
                    <label class="font-field-title">Nama Lengkap *</label>
                    <input class="form-control font-field" style="width: 100%; height: 50px;" type="text" autocomplete="off" name="fullname" value="<?php echo $user_profile['fullname'];?>" required="true">
                </div>
                <div class="form-group" style="width: 100%">
                    <label class="font-field-title">Email *</label>
                    <input class="form-control font-field" style="width: 100%; height: 50px;" type="email" autocomplete="off" name="email" value="<?php echo $user_profile['email'];?>" required="true">
                </div>
                <div class="form-group" style="width: 100%">
                    <label class="font-field-title">Nomor Handphone *</label>
                    <input class="form-control font-field" style="width: 100%; height: 50px;" type="text" autocomplete="off" name="phone" value="<?php echo $user_profile['phone'];?>" required="true">
                </div>
                <div class="form-group" style="width: 100%">
                    <label class="font-field-title">Identitas (KTP/SIM/PASSPORT) *</label>
                    <input type="file" class="form-control" name="userfile" style="padding: 3px;" required="true">
                </div>
            </div>
            <hr class="profile-line"/>
            <div class="row mt-4">
                <div class="col-md-12 content-right">
                    <button class="btn btn-karcis-primary p-0 m-0" style="width: 180px; height: 50px;" type="submit">SIMPAN</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include "footer.php";
?>