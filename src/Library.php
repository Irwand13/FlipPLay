<?php

declare(strict_types=1);

namespace FlipPlay;

class Library
{
    /** @var Media[] */
    private array $items = [];

    public function addMedia(Media $media): void
    {
        $this->items[] = $media;
    }

    /** @return Media[] */
    public function getAll(): array
    {
        return $this->items;
    }

    /** @return Media[] */
    public function getAvailable(): array
    {
        return array_values(array_filter(
            $this->items,
            fn (Media $media) => $media->isAvailable(),
        ));
    }

    /** @return Media[] */
    public function searchByTitle(string $keyword): array
    {
        return array_values(array_filter(
            $this->items,
            fn (Media $media) => stripos($media->getTitle(), $keyword) !== false,
        ));
    }

    /** @return Media[] */
    public function filterByGenre(string $genre): array
    {
        return array_values(array_filter(
            $this->items,
            fn (Media $media) => strcasecmp($media->getGenre(), $genre) === 0,
        ));
    }

    public function findByTitle(string $title): ?Media
    {
        foreach ($this->items as $media) {
            if (strcasecmp($media->getTitle(), $title) === 0) {
                return $media;
            }
        }

        return null;
    }
}
