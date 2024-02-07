<?php
include_once __DIR__ . '/hw_data/Author.php';
const ERROR_FILE = __DIR__ . '/hw_data/error_data.txt';
$errors = ['Eesnime pikkus peab olema 1 kuni 21 märki', 'Perekonnanime pikkus peab olema 2 kuni 22 märki'];
$currentErrors = [];
$myAuthor = new Author(0, "", "", "");
$editScreen = False;
if (isset($_GET['errorCode'])) {
    $tokens = explode(';.+-', file_get_contents(ERROR_FILE));
    $myAuthor->firstName = str_replace("__newline__", "\n", $tokens[0]);
    $myAuthor->lastName = str_replace("__newline__", "\n", $tokens[1]);
    $myAuthor->grade = $tokens[2];
    $errorCode = $_GET['errorCode'];
    if ($errorCode !== '2') {
        $currentErrors[] = $errors[$errorCode];
    } else {
        $currentErrors = $errors;
    }
}
if (isset($_GET['id'])) {
    require_once __DIR__ . '/hw_data/getObjects.php';
    $editScreen = True;
    $authors = getAuthors();
    $id = $_GET['id'];
    $myAuthor = findAuthor($authors, $id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Book Page</title>
</head>
<body id="author-form-page">
<nav class="header">
    <div class="header-content">
        <a href="index.php" id="book-list-link">Raamatud</a> |
        <a href="book-add.php" id="book-form-link">Lisa raamat</a> |
        <a href="author-list.php" id="author-list-link">Autorid</a> |
        <a href="" id="author-form-link">Lisa autor</a>
    </div>
</nav>
    <main>
        <?php if (!empty($currentErrors)): ?>
            <div id="error-block">
            <?php foreach ($currentErrors as $error): ?>
                <strong><?= $error ?></strong><br>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form id="author-form" action="" method="POST">
            <div class="input-box">
                <div class="label-cell"><label for="firstname">Eesnimi:</label></div>
                <div class="input-cell">
                    <input id="firstname" name="firstName" type="text" value="<?= $myAuthor->firstName?>">
                </div>
            </div>
            <div class="input-box">
                <div class="label-cell"><label for="lastname">Perekonnanimi:</label></div>
                <div class="input-cell">
                    <input id="lastname" name="lastName" type="text" value="<?= $myAuthor->lastName?>">
                </div>
            </div>
            <div class="grade-input">
                <div class="label-cell">Hinne:</div>
                <div class="input-cell">
                    <?php foreach (range(1, 5) as $grade): ?>
                        <label>
                            <input type="radio" name="grade"
                            <?= $grade == $myAuthor->grade ? 'checked' : '' ?>
                               value="<?= $grade ?>"><?= $grade ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="submit-input">
                <?php if ($editScreen): ?>
                    <input name="deleteButton"
                           class="danger"
                           type="submit"
                           value="Kustuta">
                <?php endif; ?>
                <input name="submitButton" type="submit" value="Salvesta">
            </div>
        </form>

    </main>
<footer class="footer">
    <div id="footer-content">
        ICD0007 | Magnar Markvart | Raamatud
    </div>
</footer>
</body>
</html>

<?php
const DATA_FILE = __DIR__ . '/hw_data/author_data.txt';
const ID_FILE = __DIR__ . '/hw_data/author_id.txt';
require_once __DIR__ . '/hw_data/errors.php';
require_once __DIR__ . '/hw_data/getObjects.php';
if (isset($_POST['submitButton'])) {
    $firstName = str_replace("\n", "__newline__", $_POST['firstName']);
    $lastName = str_replace("\n", "__newline__", $_POST['lastName']);
    $grade = $_POST['grade'];
    $errors = detectErrorsAuthor($firstName, $lastName);
    if (!$editScreen) {
        if (empty($errors)) {
            $id = intval(file_get_contents(ID_FILE));
            file_put_contents(ID_FILE, $id + 1);
            $author = $id . ";.+-" . $firstName . ";.+-" . $lastName . ";.+-" . $grade . "\n";
            $file = fopen(DATA_FILE, "a+");
            fwrite($file, $author);
            fclose($file);
            header("Location: author-list.php?addSuccess="."1");
        } else {
            file_put_contents(ERROR_FILE, $firstName . ";.+-" . $lastName . ";.+-" . $grade);
            header("Location: author-add.php?errorCode=".end($errors));
        }
    } else {
        if (empty($errors)) {
            $author = $myAuthor->id . ";.+-" . $firstName . ";.+-" . $lastName . ";.+-" . $grade . "\n";
            modifyAuthor($myAuthor->id, $author);
            header("Location: author-list.php?addSuccess="."2");
        } else {
            file_put_contents(ERROR_FILE, $firstName . ";.+-" . $lastName . ";.+-" . $grade);
            header("Location: book-add.php?errorCode=".end($errors));
        }
    }
}
if (isset($_POST['deleteButton'])) {
    modifyAuthor($myAuthor->id, "");
    header("Location: author-list.php?addSuccess="."3");
}
?>