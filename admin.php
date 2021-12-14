<?php
include "header.php";

@session_start();

$id = @$_SESSION['id'];

?>
<div class="login-clean">
    <form>
        <h2 class>Halaman Admin</h2>
    </form>
</div>

<?php
include "footer.php";
?>