<?php

declare(strict_types=1);

namespace FlipPlay;

class Drama extends Media
{
    public function __construct(
        string $title,
        string $genre,
        int $releaseYear,
        private string $studio,
        private int $episodes,
        bool $available = true,
    ) {
        parent::__construct($title, $genre, $releaseYear, $available);
    }

    public function getType(): string
    {
        return 'Drama';
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " - Studio: {$this->studio}, {$this->episodes} episode";
    }
}
