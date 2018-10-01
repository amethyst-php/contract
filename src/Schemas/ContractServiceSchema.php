<?php

namespace Railken\Amethyst\Schemas;

use Railken\Amethyst\Attributes as AmethystAttributes;
use Railken\Amethyst\Managers\AddressManager;
use Railken\Amethyst\Managers\ContractManager;
use Railken\Amethyst\Managers\CustomerManager;
use Railken\Amethyst\Managers\RecurringServiceManager;
use Railken\Amethyst\Managers\TaxManager;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class ContractServiceSchema extends Schema
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
            Attributes\TextAttribute::make('code')
                ->setRequired(true)
                ->setUnique(true),
            Attributes\LongTextAttribute::make('notes'),
            AmethystAttributes\CountryAttribute::make('country'),
            AmethystAttributes\CurrencyAttribute::make('currency'),
            AmethystAttributes\LocaleAttribute::make('locale'),
            Attributes\NumberAttribute::make('price_starting'),
            Attributes\NumberAttribute::make('price'),
            Attributes\NumberAttribute::make('price_ending'),
            Attributes\BelongsToAttribute::make('tax_id')
                ->setRelationName('tax')
                ->setRelationManager(TaxManager::class),
            Attributes\BelongsToAttribute::make('customer_id')
                ->setRelationName('customer')
                ->setRelationManager(CustomerManager::class),
            Attributes\BelongsToAttribute::make('address_id')
                ->setRelationName('address')
                ->setRelationManager(AddressManager::class),
            Attributes\BelongsToAttribute::make('contract_id')
                ->setRelationName('contract')
                ->setRelationManager(ContractManager::class),
            Attributes\BelongsToAttribute::make('service_id')
                ->setRelationName('service')
                ->setRelationManager(RecurringServiceManager::class),
            Attributes\EnumAttribute::make('frequency_unit', ['hours', 'days', 'weeks', 'months', 'years']),
            Attributes\NumberAttribute::make('frequency_value'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
