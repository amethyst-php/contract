<?php

namespace Amethyst\Events;

use Illuminate\Queue\SerializesModels;
use Amethyst\Models\Contract;

abstract class ContractEvent
{
    use SerializesModels;

    /**
     * @var \Amethyst\Models\Contract
     */
    public $contract;

    /**
     * Create a new event instance.
     *
     * @param \Amethyst\Models\Contract $contract
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }
}
