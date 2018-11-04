<?php

namespace Railken\Amethyst\Managers;

use Railken\Amethyst\Common\ConfigurableManager;
use Railken\Amethyst\Events;
use Railken\Amethyst\Models\Contract;
use Railken\Amethyst\Schemas\ContractSchema;
use Railken\Lem\Manager;
use Railken\Lem\Result;

class ContractManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.contract.data.contract';

    /**
     * @param \Railken\Amethyst\Models\Contract $contract
     *
     * @return Result
     */
    public function start(Contract $contract)
    {
        $contract->status = ContractSchema::STATUS_STARTED;
        $contract->started_at = new \DateTime();
        $contract->save();

        event(new Events\ContractStarted($contract));

        $result = new Result();
        $result->getResources()->push($contract);

        return $result;
    }

    /**
     * @param \Railken\Amethyst\Models\Contract $contract
     *
     * @return Result
     */
    public function suspend(Contract $contract)
    {
        $contract->status = ContractSchema::STATUS_SUSPENDED;
        $contract->suspended_at = new \DateTime();
        $contract->save();

        event(new Events\ContractSuspended($contract));

        $result = new Result();
        $result->getResources()->push($contract);

        return $result;
    }

    /**
     * @param \Railken\Amethyst\Models\Contract $contract
     *
     * @return Result
     */
    public function resume(Contract $contract)
    {
        $contract->status = ContractSchema::STATUS_STARTED;
        $contract->started_at = new \DateTime();
        $contract->save();

        event(new Events\ContractResumed($contract));

        $result = new Result();
        $result->getResources()->push($contract);

        return $result;
    }

    /**
     * @param \Railken\Amethyst\Models\Contract $contract
     *
     * @return Result
     */
    public function terminate(Contract $contract)
    {
        $contract->status = ContractSchema::STATUS_TERMINATED;
        $contract->terminated_at = new \DateTime();
        $contract->save();

        event(new Events\ContractTerminated($contract));

        $result = new Result();
        $result->getResources()->push($contract);

        return $result;
    }
}
