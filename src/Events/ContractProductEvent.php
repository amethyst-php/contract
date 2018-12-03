<?php

namespace Railken\Amethyst\Events;

use Illuminate\Queue\SerializesModels;
use Railken\Amethyst\Models\ContractProduct;

abstract class ContractProductEvent
{
    use SerializesModels;

    /**
     * @var \Railken\Amethyst\Models\ContractProduct
     */
    public $contractProduct;

    /**
     * Create a new event instance.
     *
     * @param \Railken\Amethyst\Models\ContractProduct $contractProduct
     */
    public function __construct(ContractProduct $contractProduct)
    {
        $this->contractProduct = $contractProduct;
    }
}
