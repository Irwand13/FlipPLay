<?php

declare(strict_types=1);

namespace FlipPlay;

abstract class Media
{
    public function __construct(
        protected string $title,
        protected string $genre,
        protected int $releaseYear,
        private bool $available = true,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): void
    {
        $this->available = $available;
    }

    abstract public function getType(): string;

    public function getInfo(): string
    {
        $status = $this->available ? 'Tersedia' : 'Tidak tersedia';

        return "{$this->title} ({$this->releaseYear}) - {$this->genre} - {$status}";
    }
}
