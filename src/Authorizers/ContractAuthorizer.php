<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class ContractAuthorizer extends Authorizer
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
