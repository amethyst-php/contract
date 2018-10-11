<?php

namespace Railken\Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Attributes as AmethystAttributes;
use Railken\Amethyst\Managers\CustomerManager;
use Railken\Amethyst\Managers\TaxManager;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class ContractSchema extends Schema
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
            AmethystAttributes\Invoice\CurrencyAttribute::make('currency'),
            AmethystAttributes\Invoice\LocaleAttribute::make('locale'),
            Attributes\LongTextAttribute::make('description'),
            Attributes\BooleanAttribute::make('enabled'),
            Attributes\NumberAttribute::make('price_starting'),
            Attributes\NumberAttribute::make('price'),
            Attributes\NumberAttribute::make('price_ending'),
            Attributes\BelongsToAttribute::make('tax_id')
                ->setRelationName('tax')
                ->setRelationManager(TaxManager::class),
            Attributes\BelongsToAttribute::make('customer_id')
                ->setRelationName('customer')
                ->setRelationManager(CustomerManager::class),
            Attributes\EnumAttribute::make('frequency_unit', ['hours', 'days', 'weeks', 'months', 'years']),
            Attributes\NumberAttribute::make('frequency_value'),
            Attributes\DateTimeAttribute::make('last_bill_at'),
            Attributes\DateTimeAttribute::make('next_bill_at'),
            Attributes\DateTimeAttribute::make('starts_at'),
            Attributes\DateTimeAttribute::make('ends_at'),
            Attributes\NumberAttribute::make('renewals'),
            Attributes\EnumAttribute::make('payment_method', Config::get('amethyst.contract.managers.contract.payment_methods')),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
