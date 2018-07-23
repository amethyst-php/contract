<?php

namespace Railken\LaraOre\Tests\ContractService;

use Illuminate\Support\Facades\Config;
use Railken\LaraOre\Support\Testing\ApiTestableTrait;

class ApiTest extends BaseTest
{
    use ApiTestableTrait;

    /**
     * Retrieve basic url.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return Config::get('ore.api.router.prefix').Config::get('ore.contract-service.http.admin.router.prefix');
    }

    /**
     * Test common requests.
     */
    public function testSuccessCommon()
    {
        $this->commonTest($this->getBaseUrl(), $parameters = $this->getParameters());
    }

    /**
     * Test common requests.
     */
    public function testCreateWithoutParams()
    {
        $this->commonTest(
            $this->getBaseUrl(),
            $this->getParameters()
            ->remove('price')
            ->remove('price_start')
            ->remove('price_end')
            ->remove('frequency_unit')
            ->remove('frequency_value')
            ->remove('tax_id')
            ->remove('code')
        );
    }
}
