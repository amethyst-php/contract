<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\ContractProductFaker;
use Railken\Amethyst\Managers\ContractProductManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class ContractProductTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = ContractProductManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ContractProductFaker::class;
}
