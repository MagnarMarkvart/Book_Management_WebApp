<?php

class Author {

    public int $id;
    public string $firstName;
    public string $lastName;
    public string $grade;

    public function __construct(int $id, string $firstName, string $lastName, string $grade) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->grade = $grade;
    }

    public function __toString() : string {
        return sprintf('Name: %s, %s, Grade: %s' . PHP_EOL,
            $this->firstName, $this->lastName, $this->grade);
    }

}