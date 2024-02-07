<?php
require_once __DIR__ . '/hw_data/getObjects.php';
$authors = getAuthors();
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Book Page</title>
</head>

<body id="author-list-page">

<nav class="header">
    <div id="header-content">
        <a href="index.php" id="book-list-link">Raamatud</a> |
        <a href="book-add.php" id="book-form-link">Lisa raamat</a> |
        <a href="" id="author-list-link">Autorid</a> |
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
        <div id="author-list-table">
            <div class="header-row">
                <div class="firstname-cell header-cell">Eesnimi</div>
                <div class="lastname-cell header-cell">Perekonnanimi</div>
                <div class="grade-cell header-cell">Hinne</div>
            </div>
            <div class="content-row">
                <div class="firstname-cell content-cell">J.K.</div>
                <div class="lastname-cell content-cell">Rowling</div>
                <div class="grade-cell content-cell">5</div>
            </div>
            <div class="content-row">
                <div class="firstname-cell content-cell">Jumal</div>
                <div class="lastname-cell content-cell">Jumal</div>
                <div class="grade-cell content-cell">6</div>
            </div>
            <div class="content-row">
                <div class="firstname-cell content-cell">Oskar</div>
                <div class="lastname-cell content-cell">Luts</div>
                <div class="grade-cell content-cell">5</div>
            </div>
            <?php if (!empty($authors)): ?>
                <?php foreach ($authors as $author): ?>
                    <div class="content-row">
                        <div class="firstname-cell content-cell">
                            <a href="author-add.php?id=<?=$author->id?>"><?=$author->firstName?></a>
                        </div>
                        <div class="lastname-cell content-cell"><?= $author->lastName ?></div>
                        <div class="grade-cell content-cell"><?= $author->grade ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
<footer class="footer">

    <div id="footer-content"> ICD0007 | Magnar Markvart | Raamatud </div>

</footer>

</body>

</html>