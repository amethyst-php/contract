<?php

namespace Amethyst\Tests\Http\Admin;

use Amethyst\Api\Support\Testing\TestableBaseTrait;
use Amethyst\Fakers\ContractProductFaker;
use Amethyst\Managers\ContractProductManager;
use Amethyst\Tests\BaseTest;

class ContractProductTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ContractProductFaker::class;

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
    protected $route = 'admin.contract-product';

    /**
     * Test actions.
     */
    public function testActions()
    {
        $manager = new ContractProductManager();
        $result = $manager->create(ContractProductFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());

        $this->callAndTest('POST', route('admin.contract-product.start', ['id' => $result->getResource()->id]), [], 200);
        $this->callAndTest('POST', route('admin.contract-product.suspend', ['id' => $result->getResource()->id]), [], 200);
        $this->callAndTest('POST', route('admin.contract-product.resume', ['id' => $result->getResource()->id]), [], 200);
        $this->callAndTest('POST', route('admin.contract-product.terminate', ['id' => $result->getResource()->id]), [], 200);
    }
}
