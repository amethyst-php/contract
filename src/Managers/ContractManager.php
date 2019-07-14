<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Amethyst\Events;
use Amethyst\Models\Contract;
use Amethyst\Schemas\ContractSchema;
use Railken\Lem\Manager;
use Railken\Lem\Result;

/**
 * @method \Amethyst\Models\Contract newEntity()
 * @method \Amethyst\Schemas\ContractSchema getSchema()
 * @method \Amethyst\Repositories\ContractRepository getRepository()
 * @method \Amethyst\Serializers\ContractSerializer getSerializer()
 * @method \Amethyst\Validators\ContractValidator getValidator()
 * @method \Amethyst\Authorizers\ContractAuthorizer getAuthorizer()
 */
class ContractManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.contract.data.contract';

    /**
     * @param \Amethyst\Models\Contract $contract
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
     * @param \Amethyst\Models\Contract $contract
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
     * @param \Amethyst\Models\Contract $contract
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
     * @param \Amethyst\Models\Contract $contract
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
