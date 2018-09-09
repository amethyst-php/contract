<?php

namespace Railken\LaraOre\Tests\Contract;

use Illuminate\Support\Facades\Config;
use Railken\LaraOre\Api\Support\Testing\TestableTrait;

class ApiTest extends BaseTest
{
    use TestableTrait;

    /**
     * Retrieve basic url.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return Config::get('ore.api.http.admin.router.prefix').Config::get('ore.contract.http.admin.router.prefix');
    }

    /**
     * Test common requests.
     */
    public function testSuccessCommon()
    {
        $this->commonTest($this->getBaseUrl(), $parameters = $this->getParameters());
    }
}
