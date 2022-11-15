<?php

namespace App\Entity;

class Shop
{
    private ?int $id;
    private ?string $name;

    public function __construct(array $values)
    {
        [
            'id' => $this->id,
            'name' => $this->name,
        ] = $values;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
