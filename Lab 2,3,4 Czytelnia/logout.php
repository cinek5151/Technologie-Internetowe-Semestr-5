<?php

include_once "DAL/session.php";

$session = new Session();
$session->logOut();

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}