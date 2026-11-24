<?php

declare(strict_types=1);

namespace FlipPlay;

class Anime extends Media
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
        return 'Anime';
    }

    public function getStudio(): string
    {
        return $this->studio;
    }

    public function getEpisodes(): int
    {
        return $this->episodes;
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " - Studio: {$this->studio}, {$this->episodes} episode";
    }
}