<?php

include "header.php";
@session_start();

$id = $_SESSION['id'];
$tipe = $_SESSION['tipe'];

if(!$id){
    unset($_SESSION["id"]);
    unset($_SESSION["type"]);
    unset($_SESSION["fullname"]);
    session_destroy();

    header('location:'.$host.'adminxyz.php');
    exit;
}

if($tipe != 'admin'){
    unset($_SESSION["id"]);
    unset($_SESSION["type"]);
    unset($_SESSION["fullname"]);
    session_destroy();

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