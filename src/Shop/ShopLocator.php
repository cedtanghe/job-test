<?php

namespace App\Shop;

use App\Entity\Food;
use App\Entity\Shop;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ShopLocator
{
    public function __invoke(Food $food): ?Shop
    {
        return match ($food->getName()) {
            'Carrot' => $this->allShops()[0],
            'Meat' => $this->allShops()[1],
            default => null,
        };

    }

    public function allShops(): array
    {
        return [
            new Shop(['id' => 1, 'name' => 'Auchan']),
            new Shop(['id' => 2, 'name' => 'Leclerc']),
        ];
    }
}
