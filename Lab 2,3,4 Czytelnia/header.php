<?php

include_once "DAL/session.php";

$session = new Session();

?>


<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href='https://fonts.googleapis.com/css?family=Alatsi&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Alata&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/contact.css">
    <link rel="stylesheet" href="styles/about-us.css">
    <link rel="stylesheet" href="styles/books.css">
    <link rel="stylesheet" href="styles/book.css">
    <link rel="stylesheet" href="styles/reading_room.css">
    <link rel="stylesheet" href="styles/events.css">

    <title>ReadIt</title>
</head>
<body>

<header>

    <div class="main-logo">
        <img src="images/icons/two-books.svg" alt="readit">
        <p>Read</p>
        <p class="logo-second-word">It</p>
    </div>

    <div class="user-link">
        <?php
        if ($session->isLoggedIn()) {
            ?>
            <a href="logout.php">Witaj, <?=$session->getUserName()?></a>
            <?php
        } else {
            ?>
            <img src="images/icons/user.svg" alt="user">
            <a href="login.php">Zaloguj się</a>
            <?php
        }
        ?>

    </div>

    <nav class="header-links">
        <a href="index.php">Wydarzenia</a>
        <a href="books.php">Księgozbiór</a>
        <a href="reading_room.php">Czytelnia</a>
        <a href="about_us.php">O nas</a>
        <a href="contact.php">Kontakt</a>
    </nav>

</header>