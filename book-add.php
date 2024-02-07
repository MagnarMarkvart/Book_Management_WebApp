<?php
include_once __DIR__ . '/hw_data/Book.php';
const ERROR_FILE = __DIR__ . '/hw_data/error_data.txt';
$errors = ['Pealkiri peab olema 3 kuni 23 märki'];
$currentErrors = [];
$myBook = new Book("0", "", "", "");
$editScreen = False;
if (isset($_GET['id'])) {
    require_once __DIR__ . '/hw_data/getObjects.php';
    $editScreen = True;
    $books = getBooks();
    $id = $_GET['id'];
    $myBook = findBook($books, $id);
}

if (isset($_GET['errorCode'])) {
    $tokens = explode(';.+-', file_get_contents(ERROR_FILE));
    $myBook->id = $tokens[0];
    $myBook->title = str_replace("__newline__", "\n", $tokens[1]);
    $myBook->grade = str_replace("__newline__", "\n", $tokens[2]);
    $myBook->isRead = $tokens[3];
    $errorCode = $_GET['errorCode'];
    $currentErrors[] = $errors[$errorCode];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Book Page</title>
</head>
<body id="book-form-page">
<nav class="header">
    <div class="header-content">
        <a href="index.php" id="book-list-link">Raamatud</a> |
        <a href="" id="book-form-link">Lisa raamat</a> |
        <a href="author-list.php" id="author-list-link">Autorid</a> |
        <a href="author-add.php" id="author-form-link">Lisa autor</a>
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

        <form id="book-form" action="" method="POST">
            <div class="input-box">
                <div class="label-cell"><label for="title">Pealkiri:</label></div>
                <div class="input-cell">
                    <input id="title" name="title" type="text" value="<?=$myBook->title?>">
                </div>
            </div>
            <?php include __DIR__ . '/hw_data/author_menus.php'; ?>
            <div class="grade-input">
                <div class="label-cell">Hinne:</div>
                <div class="input-cell">
                    <?php foreach (range(1, 5) as $grade):?>
                        <label>
                            <input type="radio" name="grade" <?=$grade == $myBook->grade ? 'checked' : ''?> value="<?=$grade?>"><?=$grade?>
                        </label>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="isRead-input">
                <div class="label-cell"><label for="read">Loetud:</label></div>
                <div class="input-cell"><input id="read" name="isRead" type="checkbox"
                        <?='yes' == $myBook->isRead ? 'checked' : ''?>></div>
            </div>
            <div class="submit-input">
                <?php if ($editScreen): ?>
                    <input name="deleteButton"
                           class="danger"
                           type="submit"
                           value="Kustuta">
                <?php endif;?>
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
const DATA_FILE = __DIR__ . '/hw_data/book_data.txt';
const ID_FILE = __DIR__ . '/hw_data/book_id.txt';
require_once __DIR__ . '/hw_data/errors.php';
require_once __DIR__ . '/hw_data/getObjects.php';
if (isset($_POST['submitButton'])) {
    $title = str_replace("\n", "__newline__", $_POST['title']);
    $grade = $_POST['grade'];
    if (isset($_POST['isRead'])) {
        $isRead = 'yes';
    } else {
        $isRead = 'no';
    }
    $bookAuthors = [$_POST['author1'], $_POST['author2']];
    $errors = detectErrorsBook($title);
    if (!$editScreen) {
        if (empty($errors)) {
            $id = file_get_contents(ID_FILE);
            file_put_contents(ID_FILE, $id + 1);
            $book = getBookAddString($id, $title, $grade, $isRead, $bookAuthors);
            addBookToFile($book);
            header("Location: index.php?addSuccess="."1");
        } else {
            $book = getBookAddString("0", $title, $grade, $isRead, $bookAuthors);
            file_put_contents(ERROR_FILE, $book);
            header("Location: book-add.php?errorCode=".end($errors));
        }
    } else {
        $book = getBookAddString($myBook->id, $title, $grade, $isRead, $bookAuthors);
        if (empty($errors)) {
            modifyBook($myBook->id, $book);
            header("Location: index.php?addSuccess="."2");
        } else {
            file_put_contents(ERROR_FILE, $book);
            header("Location: book-add.php?errorCode=".end($errors) . "&id=".$myBook->id);
        }
    }
}
if (isset($_POST['deleteButton'])) {
    modifyBook($myBook->id, "");
    header("Location: index.php?addSuccess="."3");
}
?>