<?php
include_once "header.php";

$session = new Session();
$db = new DBRepository();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
}

$userEmail = $session->getUserEmail();
$userId = $db->getUserIdByEmail($userEmail);

$booksArr = $db->getBorrowedBooks($userId);
$books = array();

while($book = $booksArr->fetch_assoc()){
    $books[] = $book;
}

$actualReading = null;

if(isset($_GET['id'])){
    $bookId = $_GET['id'];
    $actualReading = $db->getBookById($bookId);
}else{
    if(count($books) > 0){
        $actualReading = $books[count($books) - 1];
    }
}

if($actualReading == null){
    header("Location: books.php");
}

?>

<div class="container">

    <?php
    if (count($books) > 0){
    ?>

    <span class="room-header">
        Aktualnie na wypożyczeniu:
    </span>

    <div class="books-container">
        <?php
        foreach ($books as $book) {
            ?>

            <a href="book.php?id=<?= $book['book_id'] ?>" class="book">
                <img alt="book" src="images/books/<?= $book['image_href'] ?>">
                <div class="book-content">
                    <span class="book-title"><?= $book['title'] ?></span>
                    <span class="book-author"><?= $book['author'] ?></span>
                </div>
            </a>

            <?php
        }
        }
        ?>
    </div>

    <div class="reading-container">

    <span class="room-header">
        Czytaj dalej - <?=$actualReading['title']?>(<?=$actualReading['author']?>):
    </span>
        <iframe class="pdf" src="<?=$actualReading['pdf_href']?>#toolbar=0"></iframe>

    </div>

</div>

<?php
include_once "footer.php";
?>
