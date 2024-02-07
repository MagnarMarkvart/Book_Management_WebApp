<?php
require_once __DIR__ . '/hw_data/getObjects.php';
$books = getBooks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Book Page</title>
</head>
<body id="book-list-page">
<nav class="header">
    <div class="header-content">
        <a href="" id="book-list-link">Raamatud</a> |
        <a href="book-add.php" id="book-form-link">Lisa raamat</a> |
        <a href="author-list.php" id="author-list-link">Autorid</a> |
        <a href="author-add.php" id="author-form-link">Lisa autor</a>
    </div>
</nav>
    <main>
        <?php if (isset($_GET['addSuccess'])): ?>
            <div id="message-block">
                <?php if ($_GET['addSuccess'] == 2): ?>
                    <strong>Muudetud!</strong>
                <?php endif; ?>
                <?php if ($_GET['addSuccess'] == 1): ?>
                    <strong>Lisamine õnnestus!</strong>
                <?php endif; ?>
                <?php if ($_GET['addSuccess'] == 3): ?>
                    <strong>Kustutatud!</strong>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div id="book-list-table">
            <div class="header-row">
                <div class="title-cell header-cell">Pealkiri</div>
                <div class="author-cell header-cell">Autorid</div>
                <div class="grade-cell header-cell">Hinne</div>
            </div>
            <div class="content-row">
                <div class="title-cell content-cell">Harry Potter</div>
                <div class="author-cell content-cell">J.K.Rowling</div>
                <div class="grade-cell content-cell">5</div>
            </div>
            <div class="content-row">
                <div class="title-cell content-cell">Piibel</div>
                <div class="author-cell content-cell">Jumal</div>
                <div class="grade-cell content-cell">6</div>
            </div>
            <div class="content-row">
                <div class="title-cell content-cell">Kevade</div>
                <div class="author-cell content-cell">Oskar Luts</div>
                <div class="grade-cell content-cell">5</div>
            </div>
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <div class="content-row">
                        <div class="title-cell content-cell">
                            <a href="book-add.php?id=<?=$book->id?>"><?=$book->title?></a>
                        </div>
                        <div class="author-cell content-cell"><?= getFullAuthors($book) ?></div>
                        <div class="grade-cell content-cell"><?= $book->grade ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
<footer class="footer">
    <div id="footer-content">
        ICD0007 | Magnar Markvart | Raamatud
    </div>
</footer>
</body>
</html>