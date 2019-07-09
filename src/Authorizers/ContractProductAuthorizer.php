<?php

namespace Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class ContractProductAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'contract_product.create',
        Tokens::PERMISSION_UPDATE => 'contract_product.update',
        Tokens::PERMISSION_SHOW   => 'contract_product.show',
        Tokens::PERMISSION_REMOVE => 'contract_product.remove',
    ];
}
