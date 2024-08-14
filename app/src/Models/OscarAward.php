<?php

namespace App\Models;

class OscarAward
{
    private int $year;
    private string $name;
    private int $age;
    private string $movie;
    private bool $isFemale;

    public function __construct(array $data, bool $isFemale)
    {
        $this->year = $data['Year'];
        $this->name = $data['Name'];
        $this->age = $data['Age'];
        $this->movie = $data['Movie'];
        $this->isFemale = $isFemale;
    }

    public function isFemale(): bool
    {
        return $this->isFemale;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getMovie(): string
    {
        return $this->movie;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}
