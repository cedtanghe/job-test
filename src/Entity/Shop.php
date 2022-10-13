<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\State\ShopProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/magasin/{id}',
            provider: ShopProvider::class
        ),
        new GetCollection(
            uriTemplate: '/magasins',
            provider: ShopProvider::class
        ),
    ]
)]
class Shop
{
    public ?int $id = null;
    public ?string $name = null;

    public function __construct(array $values)
    {
        [
            'id' => $this->id,
            'name' => $this->name,
        ] = $values;
    }
}
