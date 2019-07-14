<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Amethyst\Events;
use Amethyst\Models\ContractProduct;
use Amethyst\Schemas\ContractProductSchema;
use Railken\Lem\Manager;
use Railken\Lem\Result;

/**
 * @method \Amethyst\Models\ContractProduct newEntity()
 * @method \Amethyst\Schemas\ContractProductSchema getSchema()
 * @method \Amethyst\Repositories\ContractProductRepository getRepository()
 * @method \Amethyst\Serializers\ContractProductSerializer getSerializer()
 * @method \Amethyst\Validators\ContractProductValidator getValidator()
 * @method \Amethyst\Authorizers\ContractProductAuthorizer getAuthorizer()
 */
class ContractProductManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.contract.data.contract-product';

    /**
     * @param \Amethyst\Models\ContractProduct $contractProduct
     *
     * @return Result
     */
    public function start(ContractProduct $contractProduct)
    {
        $contractProduct->status = ContractProductSchema::STATUS_STARTED;
        $contractProduct->started_at = new \DateTime();
        $contractProduct->save();

        event(new Events\ContractProductStarted($contractProduct));

        $result = new Result();
        $result->getResources()->push($contractProduct);

        return $result;
    }

    /**
     * @param \Amethyst\Models\ContractProduct $contractProduct
     *
     * @return Result
     */
    public function suspend(ContractProduct $contractProduct)
    {
        $contractProduct->status = ContractProductSchema::STATUS_SUSPENDED;
        $contractProduct->suspended_at = new \DateTime();
        $contractProduct->save();

        event(new Events\ContractProductSuspended($contractProduct));

        $result = new Result();
        $result->getResources()->push($contractProduct);

        return $result;
    }

    /**
     * @param \Amethyst\Models\ContractProduct $contractProduct
     *
     * @return Result
     */
    public function resume(ContractProduct $contractProduct)
    {
        $contractProduct->status = ContractProductSchema::STATUS_STARTED;
        $contractProduct->started_at = new \DateTime();
        $contractProduct->save();

        event(new Events\ContractProductResumed($contractProduct));

        $result = new Result();
        $result->getResources()->push($contractProduct);

        return $result;
    }

    /**
     * @param \Amethyst\Models\ContractProduct $contractProduct
     *
     * @return Result
     */
    public function terminate(ContractProduct $contractProduct)
    {
        $contractProduct->status = ContractProductSchema::STATUS_TERMINATED;
        $contractProduct->terminated_at = new \DateTime();
        $contractProduct->save();

        event(new Events\ContractProductTerminated($contractProduct));

        $result = new Result();
        $result->getResources()->push($contractProduct);

        return $result;
    }
}
