<?php

namespace Railken\Amethyst\Events;

use Railken\Amethyst\Models\ContractProduct;
use Illuminate\Queue\SerializesModels;

abstract class ContractProductEvent
{
    use SerializesModels;

    /**
     * @var \Railken\Amethyst\Models\ContractProduct $contractProduct
     */
    public $contractProduct;

    /**
     * Create a new event instance.
     *
     * @param \Railken\Amethyst\Models\ContractProduct $contractProduct
     */
    public function __construct(ContractProduct $contractProduct)
    {
        $this->contract = $contractProduct;
    }
}