<?php

namespace Railken\LaraOre\Http\Controllers\Admin;

use Railken\LaraOre\Api\Http\Controllers\RestController;
use Railken\LaraOre\Api\Http\Controllers\Traits as RestTraits;
use Railken\LaraOre\ContractService\ContractServiceManager;

class ContractServicesController extends RestController
{
    use RestTraits\RestIndexTrait;
    use RestTraits\RestCreateTrait;
    use RestTraits\RestUpdateTrait;
    use RestTraits\RestShowTrait;
    use RestTraits\RestRemoveTrait;

    public $queryable = [
        'id',
        'code',
        'customer_id',
        'contract_id',
        'service_id',
        'address_id',
        'tax_id',
        'frequency_unit',
        'frequency_value',
        'price',
        'price_start',
        'price_end',
        'renewals',
        'created_at',
        'updated_at',
    ];

    public $fillable = [
        'code',
        'customer_id',
        'customer',
        'contract_id',
        'contract',
        'service_id',
        'service',
        'address_id',
        'address',
        'tax_id',
        'tax',
        'frequency_unit',
        'frequency_value',
        'renewals',
        'price',
        'price_start',
        'price_end',
    ];

    /**
     * Construct.
     */
    public function __construct(ContractServiceManager $manager)
    {
        $this->manager = $manager;
        $this->manager->setAgent($this->getUser());
        parent::__construct();
    }

    /**
     * Create a new instance for query.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQuery()
    {
        return $this->manager->repository->getQuery();
    }
}
