<?php

namespace Railken\Amethyst\Schemas;

use Railken\Amethyst\Managers\ContractManager;
use Railken\Amethyst\Managers\SellableProductCatalogueManager;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class ContractProductSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\BelongsToAttribute::make('sellable_product_catalogue_id')
                ->setRelationName('sellable_product_catalogue')
                ->setRelationManager(SellableProductCatalogueManager::class),
            Attributes\BelongsToAttribute::make('contract_id')
                ->setRelationName('contract')
                ->setRelationManager(ContractManager::class),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
