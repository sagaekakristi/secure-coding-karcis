<?php

include "valid.php";
@session_start();

$id = @$_SESSION['id'];

if(!$id){
    header('location:'.$host.'signin.php');
    return;
}

$page = $_GET['page'];

if (valid_url($page) === FALSE) {
	header('location:'.$host.'404.php');
	return;
}

header("Location: ".$page);
return;
