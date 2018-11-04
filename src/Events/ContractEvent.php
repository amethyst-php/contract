<?php

namespace Railken\Amethyst\Events;

use Railken\Amethyst\Models\Contract;
use Illuminate\Queue\SerializesModels;

abstract class  ContractEvent
{
    use SerializesModels;

    /**
     * @var \Railken\Amethyst\Models\Contract $contract
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