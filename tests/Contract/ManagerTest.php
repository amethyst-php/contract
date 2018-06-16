<?php

namespace Railken\LaraOre\Tests\Contract;

use Railken\LaraOre\Contract\ContractManager;
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
        return new ContractManager();
    }

    public function testSuccessCommon()
    {
        $this->commonTest(new ContractManager(), $this->getParameters());
    }
}
