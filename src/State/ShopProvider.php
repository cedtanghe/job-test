<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Shop\ShopLocator;

class ShopProvider implements ProviderInterface
{
    public function __construct(private readonly ShopLocator $shopLocator)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            return $this->shopLocator->allShops();
        }

        foreach ($this->shopLocator->allShops() as $shop) {
            if ($shop->id === $uriVariables['id']) {
                return $shop;
            }
        }

        return null;
    }
}
