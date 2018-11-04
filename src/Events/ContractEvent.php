<?php

namespace Railken\Amethyst\Events;

use Illuminate\Queue\SerializesModels;
use Railken\Amethyst\Models\Contract;

abstract class ContractEvent
{
    use SerializesModels;

    /**
     * @var \Railken\Amethyst\Models\Contract
     */
    public $contract;

    /**
     * Create a new event instance.
     *
     * @param \Railken\Amethyst\Models\Contract $contract
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }
}
