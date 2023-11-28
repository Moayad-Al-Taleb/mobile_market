<?php

session_start();

if (empty($_SESSION["userID"])) {
    header('REFRESH:0;URL=login.php');
} else {
    if ($_SESSION['accountType'] == 1) {
        header('REFRESH:0;URL=../website/companies.php');
    } elseif ($_SESSION['accountType'] == 2) {
        header('REFRESH:0;URL=users.php');
    }
}
