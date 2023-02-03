<?php

include_once "header.php";

$db = new DBRepository();

?>

<div class="container">
    <div class="form">
        <form>
            <div class="form-row">
                <div class="form-field">
                    <input type="text" placeholder="Szukaj...">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="books-container">

    <?php

    $books = $db->getAllBooks();

    while ($book = $books->fetch_assoc()) {
        ?>

        <a href="book.php?id=<?= $book['id'] ?>" class="book">
            <img alt="book" src="images/books/<?= $book['image_href'] ?>">
            <div class="book-content">
                <span class="book-title"><?= $book['title'] ?></span>
                <span class="book-author"><?= $book['author'] ?></span>
            </div>
        </a>

        <?php
    }
    ?>

</div>


<?php

include_once "footer.php";

?>
