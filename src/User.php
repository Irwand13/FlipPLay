<?php

declare(strict_types=1);

namespace FlipPlay;

class User
{
    /** @var Media[] */
    private array $collection = [];

    public function __construct(
        private string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addToCollection(Media $media): void
    {
        $this->collection[] = $media;
    }

    /** @return Media[] */
    public function getCollection(): array
    {
        return $this->collection;
    }
}
