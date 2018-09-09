<?php

namespace Railken\LaraOre\Tests\ContractService;

use Illuminate\Support\Facades\Config;
use Railken\LaraOre\Api\Support\Testing\TestableBaseTrait;
use Railken\LaraOre\ContractService\ContractServiceFaker;

class ApiTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ContractServiceFaker::class;

    /**
     * Router group resource.
     *
     * @var string
     */
    protected $group = 'admin';

    /**
     * Base path config.
     *
     * @var string
     */
    protected $config = 'ore.contract-service';
}
