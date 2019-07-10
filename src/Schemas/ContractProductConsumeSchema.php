<?php

namespace Amethyst\Schemas;

use Amethyst\Attributes as AmethystAttributes;
use Amethyst\Managers\ContractManager;
use Amethyst\Managers\ProductManager;
use Amethyst\Managers\TaxManager;
use Illuminate\Support\Facades\Config;
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
            Attributes\BelongsToAttribute::make('contract_id')
                ->setRelationName('contract')
                ->setRelationManager(ContractManager::class)
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('product_id')
                ->setRelationName('product')
                ->setRelationManager(ProductManager::class)
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('tax_id')
                ->setRelationName('tax')
                ->setRelationManager(TaxManager::class)
                ->setRequired(true),
            AmethystAttributes\TaxonomyAttribute::make('group_id', Config::get('amethyst.contract.data.contract-product.group-taxonomy'))
                ->setRelationName('group')
                ->setRequired(true),
            Attributes\NumberAttribute::make('price')
                ->setRequired(true),
            Attributes\NumberAttribute::make('value')
                ->setRequired(true),
            Attributes\LongTextAttribute::make('notes'),
            Attributes\DateTimeAttribute::make('billed_at'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
