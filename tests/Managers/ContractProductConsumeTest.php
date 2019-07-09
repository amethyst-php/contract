<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\ContractProductConsumeFaker;
use Amethyst\Managers\ContractProductConsumeManager;
use Amethyst\Tests\BaseTest;
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
