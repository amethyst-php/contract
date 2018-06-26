<?php

namespace Railken\LaraOre\ContractService;

use Illuminate\Support\Facades\Config;
use Railken\Laravel\Manager\Contracts\AgentContract;
use Railken\Laravel\Manager\ModelManager;
use Railken\Laravel\Manager\Tokens;

class ContractServiceManager extends ModelManager
{
    /**
     * Class name entity.
     *
     * @var string
     */
    public $entity = ContractService::class;

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
        Attributes\ContractId\ContractIdAttribute::class,
        Attributes\CustomerId\CustomerIdAttribute::class,
        Attributes\AddressId\AddressIdAttribute::class,
        Attributes\ServiceId\ServiceIdAttribute::class,
        Attributes\TaxId\TaxIdAttribute::class,
        Attributes\Price\PriceAttribute::class,
        Attributes\PriceStart\PriceStartAttribute::class,
        Attributes\PriceEnd\PriceEndAttribute::class,
        Attributes\FrequencyUnit\FrequencyUnitAttribute::class,
        Attributes\FrequencyValue\FrequencyValueAttribute::class,
        Attributes\Renewals\RenewalsAttribute::class,
        Attributes\Code\CodeAttribute::class,
    ];

    /**
     * List of all exceptions.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_AUTHORIZED => Exceptions\ContractServiceNotAuthorizedException::class,
    ];

    /**
     * Construct.
     *
     * @param AgentContract $agent
     */
    public function __construct(AgentContract $agent = null)
    {
        $this->attributes = array_merge($this->attributes, array_values(Config::get('ore.contract-service.attributes')));
        $this->setRepository(new ContractServiceRepository($this));
        $this->setSerializer(new ContractServiceSerializer($this));
        $this->setValidator(new ContractServiceValidator($this));
        $this->setAuthorizer(new ContractServiceAuthorizer($this));

        parent::__construct($agent);
    }
}
