<?php

include_once "header.php";

$db = new DBRepository();
$session = new Session();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
}

if (!isset($_GET['id'])) {
    header("Location: books.php");
}

$bookId = $_GET['id'];

$book = $db->getBookById($bookId);

if ($book == null) {
    header("Location: books.php");
}

$userEmail = $session->getUserEmail();
$userId = $db->getUserIdByEmail($userEmail);
$alreadyBorrowed = $db->isAlreadyBorrowed($userId, $bookId);

if ($alreadyBorrowed) {
    $borrow = $db->getBorrow($userId, $bookId);
    $startDate = date_format(date_create($borrow['start_date']), "d.m.Y");
    $diff = $db->getBorrowExpirationDays($borrow['ends_date']);
    if ($diff > 1) {
        $diff = "za " . $diff . " dni";
    } else if ($diff == 1) {
        $diff = "jutro";
    } else {
        $diff = "dzisiaj";
    }
}

if (isset($_POST['borrow'])) {

    $startDate = date("Y-m-d");
    $endsDate = Date("Y-m-d", strtotime("+10 days"));

    $result = $db->borrowBook($userId, $bookId, $startDate, $endsDate);
    if ($result) {
        header("Location: book.php?id=" . $bookId);
    }

}

if (isset($_POST['read'])) {
    header("Location: reading_room.php?id=" . $bookId);
}

?>
<div class="container">
    <div class="books-container">


        <form class="book" method="post">
            <img alt="book" src="images/books/<?= $book['image_href'] ?>">
            <div class="book-content">
                <span class="book-title"><?= $book['title'] ?></span>
                <span class="book-author"><?= $book['author'] ?></span>
            </div>

            <div class="book-buttons">
                <button type="submit" class="button-primary" name="read" id="read">Czytaj online</button>
                <?php
                if (!$alreadyBorrowed) {
                    ?>
                    <button type="submit" class="button-accent" name="borrow" id="borrow">Wypożycz</button>
                    <?php
                }
                ?>
            </div>

            <?php

            if (isset($startDate) && isset($diff)) {

                ?>

                <div class="borrow-dates">
                    <span>Wypożyczono dnia: <?= $startDate ?></span>
                    <span>Koniec: <?= $diff ?></span>
                </div>

                <?php
            }
            ?>

        </form>


    </div>
</div>

<?php

include_once "footer.php";

?>
