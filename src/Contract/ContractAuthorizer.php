<?php

namespace Railken\LaraOre\Contract;

use Railken\Laravel\Manager\ModelAuthorizer;
use Railken\Laravel\Manager\Tokens;

class ContractAuthorizer extends ModelAuthorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'contract.create',
        Tokens::PERMISSION_UPDATE => 'contract.update',
        Tokens::PERMISSION_SHOW   => 'contract.show',
        Tokens::PERMISSION_REMOVE => 'contract.remove',
    ];
}
