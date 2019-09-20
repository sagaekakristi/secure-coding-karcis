<?php
    include "header.php";

    @session_start();
    
    $id = @$_SESSION['id'];
    $tipe = @$_SESSION['tipe'];
   
    if($tipe != 'admin'){
        unset($_SESSION["id"]);
        header('location:'.$host.'adminxyz.php');
    }
?>
    <div class="login-clean">
        <form>
            <h2 class>Halaman Admin</h2>
        </form>
</div>

<?php
    include "footer.php";
?>