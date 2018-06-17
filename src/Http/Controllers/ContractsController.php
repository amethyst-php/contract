<?php

namespace Railken\LaraOre\Http\Controllers;

use Railken\LaraOre\Api\Http\Controllers\RestController;
use Railken\LaraOre\Api\Http\Controllers\Traits as RestTraits;
use Railken\LaraOre\Contract\ContractManager;

class ContractsController extends RestController
{
    use RestTraits\RestIndexTrait;
    use RestTraits\RestCreateTrait;
    use RestTraits\RestUpdateTrait;
    use RestTraits\RestShowTrait;
    use RestTraits\RestRemoveTrait;

    public $queryable = [
        'id',
        'customer_id',
        'price',
        'price_start',
        'price_end',
        'frequency_unit',
        'frequency_value',
        'code',
        'country',
        'locale',
        'currency',
        'tax_id',
        'notes',
        'address_id',
        'payment_method',
        'renewals',
        'created_at',
        'updated_at',
    ];

    public $fillable = [
        'customer_id',
        'price',
        'price_start',
        'price_end',
        'frequency_unit',
        'frequency_value',
        'code',
        'country',
        'locale',
        'currency',
        'tax_id',
        'notes',
        'address_id',
        'payment_method',
        'renewals',
    ];

    /**
     * Construct.
     */
    public function __construct(ContractManager $manager)
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
