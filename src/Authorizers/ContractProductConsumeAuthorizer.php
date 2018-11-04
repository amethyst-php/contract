<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class ContractProductConsumeAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'contract-product-consume.create',
        Tokens::PERMISSION_UPDATE => 'contract-product-consume.update',
        Tokens::PERMISSION_SHOW   => 'contract-product-consume.show',
        Tokens::PERMISSION_REMOVE => 'contract-product-consume.remove',
    ];
}
