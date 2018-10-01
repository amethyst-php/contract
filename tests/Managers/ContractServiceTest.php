<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\ContractServiceFaker;
use Railken\Amethyst\Managers\ContractServiceManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class ContractServiceTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = ContractServiceManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ContractServiceFaker::class;
}
