<?php

namespace Railken\Amethyst\Managers;

use Railken\Amethyst\Common\ConfigurableManager;
use Railken\Amethyst\Events;
use Railken\Amethyst\Models\ContractProduct;
use Railken\Amethyst\Schemas\ContractProductSchema;
use Railken\Lem\Manager;
use Railken\Lem\Result;

class ContractProductManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.contract.data.contract-product';

    /**
     * @param \Railken\Amethyst\Models\ContractProduct $contract
     *
     * @return Result
     */
    public function start(ContractProduct $contract)
    {
        $contract->status = ContractProductSchema::STATUS_STARTED;
        $contract->save();

        event(new Events\ContractProductStarted($contract));

        $result = new Result();
        $result->getResources()->push($contract);

        return $result;
    }

    /**
     * @param \Railken\Amethyst\Models\ContractProduct $contract
     *
     * @return Result
     */
    public function suspend(ContractProduct $contract)
    {
        $contract->status = ContractProductSchema::STATUS_SUSPENDED;
        $contract->save();

        event(new Events\ContractProductSuspended($contract));

        $result = new Result();
        $result->getResources()->push($contract);

        return $result;
    }

    /**
     * @param \Railken\Amethyst\Models\ContractProduct $contract
     *
     * @return Result
     */
    public function resume(ContractProduct $contract)
    {
        $contract->status = ContractProductSchema::STATUS_STARTED;
        $contract->save();

        event(new Events\ContractProductResumed($contract));

        $result = new Result();
        $result->getResources()->push($contract);

        return $result;
    }

    /**
     * @param \Railken\Amethyst\Models\ContractProduct $contract
     *
     * @return Result
     */
    public function terminate(ContractProduct $contract)
    {
        $contract->status = ContractProductSchema::STATUS_TERMINATED;
        $contract->save();

        event(new Events\ContractProductTerminated($contract));

        $result = new Result();
        $result->getResources()->push($contract);

        return $result;
    }
}
