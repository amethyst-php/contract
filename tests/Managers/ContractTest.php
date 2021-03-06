<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\ContractFaker;
use Amethyst\Managers\ContractManager;
use Amethyst\Schemas\ContractSchema;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class ContractTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = ContractManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ContractFaker::class;

    public function testStart()
    {
        $resource = $this->getManager()->create($this->faker::make()->parameters())->getResource();
        $result = $this->getManager()->start($resource);
        $this->assertEquals(ContractSchema::STATUS_STARTED, $result->getResource()->status);
    }

    public function testSuspend()
    {
        $resource = $this->getManager()->create($this->faker::make()->parameters())->getResource();
        $result = $this->getManager()->suspend($resource);
        $this->assertEquals(ContractSchema::STATUS_SUSPENDED, $result->getResource()->status);
    }

    public function testResume()
    {
        $resource = $this->getManager()->create($this->faker::make()->parameters())->getResource();
        $result = $this->getManager()->resume($resource);
        $this->assertEquals(ContractSchema::STATUS_STARTED, $result->getResource()->status);
    }

    public function testTerminate()
    {
        $resource = $this->getManager()->create($this->faker::make()->parameters())->getResource();
        $result = $this->getManager()->terminate($resource);
        $this->assertEquals(ContractSchema::STATUS_TERMINATED, $result->getResource()->status);
    }
}
