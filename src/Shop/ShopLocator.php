<?php

namespace App\Shop;

use App\Entity\Shop;

class ShopLocator
{
    public function allShops(): array
    {
        return [
            new Shop(['id' => 1, 'name' => 'Auchan']),
            new Shop(['id' => 2, 'name' => 'Leclerc']),
        ];
    }
}
