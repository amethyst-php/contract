<?php

namespace Railken\LaraOre\Tests\ContractService;

use Railken\LaraOre\ContractService\ContractServiceFaker;
use Railken\LaraOre\ContractService\ContractServiceManager;
use Railken\LaraOre\Support\Testing\ManagerTestableTrait;

class ManagerTest extends BaseTest
{
    use ManagerTestableTrait;

    /**
     * Retrieve basic url.
     *
     * @return \Railken\Laravel\Manager\Contracts\ManagerContract
     */
    public function getManager()
    {
        return new ContractServiceManager();
    }

    public function testSuccessCommon()
    {
        $this->commonTest($this->getManager(), ContractServiceFaker::make()->parameters());
    }
}
