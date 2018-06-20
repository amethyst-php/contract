<?php

namespace Railken\LaraOre\ContractService;

use Railken\Laravel\Manager\ModelAuthorizer;
use Railken\Laravel\Manager\Tokens;

class ContractServiceAuthorizer extends ModelAuthorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'contract_service.create',
        Tokens::PERMISSION_UPDATE => 'contract_service.update',
        Tokens::PERMISSION_SHOW   => 'contract_service.show',
        Tokens::PERMISSION_REMOVE => 'contract_service.remove',
    ];
}
