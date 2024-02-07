<?php

function detectErrorsAuthor(string $firstName, string $lastName): array {
    $errors = ['Eesnime pikkus peab olema 1 kuni 21 märki', 'Perekonnanime pikkus peab olema 2 kuni 22 märki'];
    $currentErrors = [];
    $errorCode = 10;
    $firstName = str_replace("__newline__", " ", $firstName);
    $lastName = str_replace("__newline__", " ", $lastName);
    if (strlen($firstName) < 1 || strlen($firstName) > 21) {
        $currentErrors[] = $errors[0];
        $errorCode = 0;
    }
    if (strlen($lastName) < 2 || strlen($lastName) > 22) {
        $currentErrors[] = $errors[1];
        if ($errorCode === 0) {
            $errorCode = 2;
        } else {
            $errorCode = 1;
        }
    }
    if ($errorCode !== 10) {
        $currentErrors[] = $errorCode;
    }

    return $currentErrors;
}

function detectErrorsBook(string $title): array {
    $errors = ['Pealkiri peab olema 3 kuni 23 märki'];
    $currentErrors = [];
    $errorCode = 10;
    $title = str_replace("__newline__", " ", $title);
    if (strlen($title) < 3 || strlen($title) > 23) {
        $currentErrors[] = $errors[0];
        $errorCode = 0;
    }
    if ($errorCode !== 10) {
        $currentErrors[] = $errorCode;
    }

    return $currentErrors;
}

?>