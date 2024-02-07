<?php


class Book {

    public int $id;
    public string $title;
    public string $grade;
    public string $isRead;
    public string $author1;
    public string $author2;

    public function __construct(string $id, string $title, string $grade, string $isRead) {
        $this->id = intval($id);
        $this->title = $title;
        $this->grade = $grade;
        $this->isRead = $isRead;
        $this->author1 = "";
        $this->author2 = "";
    }

    public function __toString() : string {
        return sprintf('Title: %s, Grade: %s, isRead: %s' . PHP_EOL,
            $this->title, $this->grade, $this->isRead);
    }
}