<?php

declare(strict_types=1);

namespace FlipPlay;

class Manga extends Media
{
    public function __construct(
        string $title,
        string $genre,
        int $releaseYear,
        private string $author,
        private int $chapters,
        bool $available = true,
    ) {
        parent::__construct($title, $genre, $releaseYear, $available);
    }

    public function getType(): string
    {
        return 'Manga';
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " - Penulis: {$this->author}, {$this->chapters} chapter";
    }
}
