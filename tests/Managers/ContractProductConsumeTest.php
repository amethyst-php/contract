<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\ContractProductConsumeFaker;
use Railken\Amethyst\Managers\ContractProductConsumeManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class ContractProductConsumeTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = ContractProductConsumeManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ContractProductConsumeFaker::class;
}
