<?php

namespace Railken\LaraOre\Tests\ContractService;

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
        $this->commonTest($this->getManager(), $this->getParameters());
    }

    public function testCreateWithoutParams()
    {
        $this->commonTest(
            $this->getManager(),
            $this->getParameters()
            ->remove('price')
            ->remove('price_start')
            ->remove('price_end')
            ->remove('frequency_unit')
            ->remove('frequency_value')
            ->remove('tax_id')
            ->remove('code')
        );
    }
}
