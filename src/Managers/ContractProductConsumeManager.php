<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\ContractProductConsume newEntity()
 * @method \Amethyst\Schemas\ContractProductConsumeSchema getSchema()
 * @method \Amethyst\Repositories\ContractProductConsumeRepository getRepository()
 * @method \Amethyst\Serializers\ContractProductConsumeSerializer getSerializer()
 * @method \Amethyst\Validators\ContractProductConsumeValidator getValidator()
 * @method \Amethyst\Authorizers\ContractProductConsumeAuthorizer getAuthorizer()
 */
class ContractProductConsumeManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.contract.data.contract-product-consume';
}
