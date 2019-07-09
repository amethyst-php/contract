<?php

namespace Amethyst\Schemas;

use Illuminate\Support\Facades\Config;
use Amethyst\Attributes as AmethystAttributes;
use Amethyst\Managers\CustomerManager;
use Amethyst\Managers\TargetManager;
use Amethyst\Managers\TaxManager;
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
            AmethystAttributes\CountryAttribute::make('country')
                ->setRequired(true),
            AmethystAttributes\Invoice\CurrencyAttribute::make('currency')
                ->setRequired(true),
            AmethystAttributes\Invoice\LocaleAttribute::make('locale')
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('tax_id')
                ->setRelationName('tax')
                ->setRelationManager(TaxManager::class)
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('customer_id')
                ->setRelationName('customer')
                ->setRelationManager(CustomerManager::class)
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('target_id')
                ->setRelationName('target')
                ->setRelationManager(TargetManager::class)
                ->setRequired(true),
            Attributes\DateTimeAttribute::make('started_at'),
            Attributes\DateTimeAttribute::make('suspended_at'),
            Attributes\DateTimeAttribute::make('terminated_at'),
            AmethystAttributes\TaxonomyAttribute::make('payment_method_id', Config::get('amethyst.contract.data.contract.attributes.payment_method.parent'))
                ->setRelationName('payment_method'),
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
