<?php

namespace Railken\LaraOre\ContractService\Attributes\UpdatedAt\Exceptions;

use Railken\LaraOre\ContractService\Exceptions\ContractServiceAttributeException;

class ContractServiceUpdatedAtNotAuthorizedException extends ContractServiceAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'updated_at';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACTSERVICE_UPDATED_AT_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
