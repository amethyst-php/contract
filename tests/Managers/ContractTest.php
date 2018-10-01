<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\ContractFaker;
use Railken\Amethyst\Issuer\BaseIssuer;
use Railken\Amethyst\Managers\ContractManager;
use Railken\Amethyst\Tests\BaseTest;
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

    /**
     * Test issuer.
     */
    public function testIssuer()
    {
        (new BaseIssuer($this->getManager()->createOrFail(ContractFaker::make()->parameters())->getResource()))->issue();
    }
}
