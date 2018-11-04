<?php

namespace Railken\Amethyst\Schemas;

use Railken\Amethyst\Managers\SellableProductCatalogueManager;
use Railken\Amethyst\Managers\ContractProductManager;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class ContractProductConsumeSchema extends Schema
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
            Attributes\BelongsToAttribute::make('contract_product_id')
                ->setRelationName('contract_product')
                ->setRelationManager(ContractProductManager::class)
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('sellable_product_id')
                ->setRelationName('sellable_product')
                ->setRelationManager(SellableProductCatalogueManager::class)
                ->setRequired(true),
            Attributes\NumberAttribute::make('value'),
            Attributes\LongTextAttribute::make('notes'),
            Attributes\DateTimeAttribute::make('billed_at'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
