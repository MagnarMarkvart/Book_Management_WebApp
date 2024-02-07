<?php
const AUTHOR_DATA_FILE = __DIR__ . '/author_data.txt';
const BOOK_DATA_FILE = __DIR__ . '/book_data.txt';
include_once 'Author.php';
include_once 'Book.php';

function getAuthors(): array {
    $lines = file(AUTHOR_DATA_FILE);
    $authors = [];
    foreach ($lines as $line) {
        $tokens = explode(';.+-', $line);
        $new_tokens = [];
        foreach ($tokens as $token) {
            $new_tokens[] = str_replace("__newline__", "\n", $token);
        }
        $author = new Author($new_tokens[0], $new_tokens[1], $new_tokens[2], $new_tokens[3]);
        $authors[] = $author;
    }
    return $authors;
}

function getBooks(): array {
    $lines = file(BOOK_DATA_FILE);
    if (empty($lines)) {
        return [];
    }
    $books = [];
    foreach ($lines as $line) {
        $tokens = explode(';.+-', $line);
        $new_tokens = [];
        foreach ($tokens as $token) {
            $new_tokens[] = str_replace("__newline__", "\n", $token);
        }
        $book = new Book($new_tokens[0], $new_tokens[1], $new_tokens[2], $new_tokens[3]);
        $book->author1 = $new_tokens[4];
        $book->author2 = $new_tokens[5];
        $books[] = $book;
    }
    return $books;
}

function findAuthor(array $authors, int $id): ?Author {
    foreach ($authors as $author) {
        if ($author->id === $id) {
            return $author;
        }
    }
    return null;
}

function findBook(array $books, int $id): ?Book {
    foreach ($books as $book) {
        if (intval($book->id) === $id) {
            return $book;
        }
    }
    return null;
}

function modifyBook(int $id, string $book): void {
    $lines = file(BOOK_DATA_FILE);
    $newData = [];
    foreach ($lines as $line) {
        $tokens = explode(';.+-', $line);
        if ($tokens[0] == strval($id)) {
            if ($book === "") {
                continue;
            } else {
                $newData[] = $book;
            }
        } else {
            $newData[] = $line;
        }
    }
    file_put_contents(BOOK_DATA_FILE, "");
    file_put_contents(BOOK_DATA_FILE, $newData);
}

function addBookToFile(string $book): void {
    $file = fopen(BOOK_DATA_FILE, "a+");
    fwrite($file, $book);
    fclose($file);
}

function modifyAuthor(int $id, string $author): void {
    $lines = file(AUTHOR_DATA_FILE);
    $newData = [];
    foreach ($lines as $line) {
        $tokens = explode(';.+-', $line);
        if ($tokens[0] == strval($id)) {
            if ($author === "") {
                continue;
            } else {
                $newData[] = $author;
            }
        } else {
            $newData[] = $line;
        }
    }
    file_put_contents(AUTHOR_DATA_FILE, "");
    file_put_contents(AUTHOR_DATA_FILE, $newData);
}

function getBookAddString(string $id, string $title, string $grade, string $isRead, array $authors): string {
    $author1 = $authors[0];
    $author2 = $authors[1];
    return $id . ";.+-" . $title . ";.+-" . $grade . ";.+-" . $isRead . ";.+-" . $author1 . ";.+-" . $author2 . ";.+-" . "\n";
}

function getFullAuthors(Book $book): string {
    $string = "";
    if ($book->author1 === "") {
        if ($book->author2 === "") {
            return $string;
        } else {
            return $book->author2;
        }
    } else {
        $string = $book->author1;
        if ($book->author2 !== "") {
            $string = $string . ", " . $book->author2;
        }
        return $string;
    }
}