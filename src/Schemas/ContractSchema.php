<?php

namespace Railken\Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Attributes as AmethystAttributes;
use Railken\Amethyst\Managers\AddressManager;
use Railken\Amethyst\Managers\CustomerManager;
use Railken\Amethyst\Managers\TaxManager;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class ContractSchema extends Schema
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_STARTED = 'started';
    public const STATUS_SUSPENDED = 'suspended';
    public const STATUS_TERMINATED = 'terminated';

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
            Attributes\BooleanAttribute::make('enabled'),
            AmethystAttributes\CountryAttribute::make('country'),
            AmethystAttributes\Invoice\CurrencyAttribute::make('currency'),
            AmethystAttributes\Invoice\LocaleAttribute::make('locale'),
            Attributes\BelongsToAttribute::make('tax_id')
                ->setRelationName('tax')
                ->setRelationManager(TaxManager::class),
            Attributes\BelongsToAttribute::make('customer_id')
                ->setRelationName('customer')
                ->setRelationManager(CustomerManager::class),
            Attributes\BelongsToAttribute::make('address_id')
                ->setRelationName('address')
                ->setRelationManager(AddressManager::class),
            Attributes\DateTimeAttribute::make('started_at'),
            Attributes\DateTimeAttribute::make('suspended_at'),
            Attributes\DateTimeAttribute::make('terminated_at'),
            Attributes\EnumAttribute::make('payment_method', Config::get('amethyst.contract.data.contract.payment_methods')),
            Attributes\EnumAttribute::make('status', [
                static::STATUS_PENDING,
                static::STATUS_STARTED,
                static::STATUS_SUSPENDED,
                static::STATUS_TERMINATED,
            ]),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
