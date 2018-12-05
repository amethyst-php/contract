<?php

namespace Railken\Amethyst\Tests\Http\Admin;

use Railken\Amethyst\Api\Support\Testing\TestableBaseTrait;
use Railken\Amethyst\Fakers\ContractFaker;
use Railken\Amethyst\Managers\ContractManager;
use Railken\Amethyst\Tests\BaseTest;

class ContractTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ContractFaker::class;

    /**
     * Router group resource.
     *
     * @var string
     */
    protected $group = 'admin';

    /**
     * Route name.
     *
     * @var string
     */
    protected $route = 'admin.contract';

    /**
     * Test actions.
     */
    public function testActions()
    {
        $manager = new ContractManager();
        $result = $manager->create(ContractFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());

        $this->callAndTest('POST', route('admin.contract.start', ['id' => $result->getResource()->id]), [], 200);
        $this->callAndTest('POST', route('admin.contract.suspend', ['id' => $result->getResource()->id]), [], 200);
        $this->callAndTest('POST', route('admin.contract.resume', ['id' => $result->getResource()->id]), [], 200);
        $this->callAndTest('POST', route('admin.contract.terminate', ['id' => $result->getResource()->id]), [], 200);
    }
}
