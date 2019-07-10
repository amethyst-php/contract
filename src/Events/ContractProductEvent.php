<?php

namespace Amethyst\Events;

use Amethyst\Models\ContractProduct;
use Illuminate\Queue\SerializesModels;

abstract class ContractProductEvent
{
    use SerializesModels;

    /**
     * @var \Amethyst\Models\ContractProduct
     */
    public $contractProduct;

    /**
     * Create a new event instance.
     *
     * @param \Amethyst\Models\ContractProduct $contractProduct
     */
    public function __construct(ContractProduct $contractProduct)
    {
        $this->contractProduct = $contractProduct;
    }
}
