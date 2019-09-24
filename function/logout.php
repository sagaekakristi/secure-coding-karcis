<?php

session_start();
unset($_SESSION["id"]);

// destroy session
session_destroy();

// revalidate back history
header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
header('Pragma', 'no-cache');
header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

header('location:../index.php');
