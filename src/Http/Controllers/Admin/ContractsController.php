<?php

namespace Railken\LaraOre\Http\Controllers\Admin;

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
        'code',
        'customer_id',
        'tax_id',
        'renewals',
        'frequency_unit',
        'frequency_value',
        'country',
        'locale',
        'currency',
        'notes',
        'payment_method',
        'starts_at',
        'ends_at',
        'last_bill_at',
        'next_bill_at',
        'created_at',
        'updated_at',
    ];

    public $fillable = [
        'code',
        'customer_id',
        'tax_id',
        'renewals',
        'frequency_unit',
        'frequency_value',
        'country',
        'locale',
        'currency',
        'notes',
        'payment_method',
        'starts_at',
        'ends_at',
        'last_bill_at',
        'next_bill_at',
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
