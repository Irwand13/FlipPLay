<?php

declare(strict_types=1);

namespace FlipPlay;

class LightNovel extends Media
{
    public function __construct(
        string $title,
        string $genre,
        int $releaseYear,
        private string $author,
        private int $volumes,
        bool $available = true,
    ) {
        parent::__construct($title, $genre, $releaseYear, $available);
    }

    public function getType(): string
    {
        return 'Light Novel';
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " - Penulis: {$this->author}, {$this->volumes} volume";
    }
}
