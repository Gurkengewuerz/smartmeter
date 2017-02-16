<?php

if ((!isset($_SESSION['rank']) || empty($_SESSION['rank'])) ||
        (!isset($_SESSION['username']) || empty($_SESSION['username']))) {
    $IsAdmin = FALSE;
    $IsUser = FALSE;
    $username = NULL;
}

$username = $_SESSION['username'];
        
if ($_SESSION['rank'] === "admin") {
    $IsAdmin = true;
}

if ($_SESSION['rank'] === "user") {
    $IsUser = true;
}
