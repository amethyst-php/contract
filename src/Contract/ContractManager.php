<?php

namespace Railken\LaraOre\Contract;

use Railken\Laravel\Manager\Contracts\AgentContract;
use Railken\Laravel\Manager\ModelManager;
use Railken\Laravel\Manager\Tokens;
use Illuminate\Support\Facades\Config;

class ContractManager extends ModelManager
{
    /**
     * Class name entity.
     *
     * @var string
     */
    public $entity = Contract::class;
    
    /**
     * List of all attributes.
     *
     * @var array
     */
    protected $attributes = [
        Attributes\Id\IdAttribute::class,
        Attributes\CreatedAt\CreatedAtAttribute::class,
        Attributes\UpdatedAt\UpdatedAtAttribute::class,
        Attributes\DeletedAt\DeletedAtAttribute::class,
        Attributes\CustomerId\CustomerIdAttribute::class,
        Attributes\Price\PriceAttribute::class,
        Attributes\PriceStart\PriceStartAttribute::class,
        Attributes\PriceEnd\PriceEndAttribute::class,
        Attributes\FrequencyUnit\FrequencyUnitAttribute::class,
        Attributes\FrequencyValue\FrequencyValueAttribute::class,
        Attributes\Code\CodeAttribute::class,
        Attributes\Country\CountryAttribute::class,
        Attributes\Locale\LocaleAttribute::class,
        Attributes\Currency\CurrencyAttribute::class,
        Attributes\TaxId\TaxIdAttribute::class,
        Attributes\Notes\NotesAttribute::class,
        Attributes\AddressId\AddressIdAttribute::class,
        Attributes\PaymentMethod\PaymentMethodAttribute::class,
        Attributes\Renewals\RenewalsAttribute::class
    ];

    /**
     * List of all exceptions.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_AUTHORIZED => Exceptions\ContractNotAuthorizedException::class,
    ];

    /**
     * Construct.
     *
     * @param AgentContract $agent
     */
    public function __construct(AgentContract $agent = null)
    {
        $this->attributes = array_merge($this->attributes, array_values(Config::get('ore.contract.attributes')));
        $this->setRepository(new ContractRepository($this));
        $this->setSerializer(new ContractSerializer($this));
        $this->setValidator(new ContractValidator($this));
        $this->setAuthorizer(new ContractAuthorizer($this));

        parent::__construct($agent);
    }
}
