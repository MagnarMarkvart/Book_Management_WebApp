<?php
require_once 'getObjects.php';

$authors = getAuthors();
$author1 = "";
$author2 = "";
if (isset($_GET['id'])) {
    $editScreen = True;
    $books = getBooks();
    $id = $_GET['id'];
    $myBook = findBook($books, $id);
    $author1 = $myBook->author1;
    $author2 = $myBook->author2;
}
echo "<div class='author-input'>";
echo "<label for='author-menu1'>Autor 1:</label><br>";
echo "<select id='Amenu1' name='author1'>";
/**
 * @param array $authors
 * @param string $author
 */
function getAuthorMenu(array $authors, string $myAuthor): void
{
    echo "<option value=''></option>";
    foreach ($authors as $author) {
        if ($myAuthor == $author->firstName . " " . $author->lastName) {
            echo "<option selected value='$author->firstName $author->lastName'>$author->firstName $author->lastName</option>";
        } else {
            echo "<option value='$author->firstName $author->lastName'>$author->firstName $author->lastName</option>";
        }
    }
    echo "</select>";
    echo "</div>";
}
getAuthorMenu($authors, $author1);
echo "<div class='author-input'>";
echo "<label for='author-menu2'>Autor 2:</label><br>";
echo "<select id='Amenu2' name='author2'>";
getAuthorMenu($authors, $author2);
