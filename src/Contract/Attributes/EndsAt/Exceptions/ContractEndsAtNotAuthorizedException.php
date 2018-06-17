<?php

namespace Railken\LaraOre\Contract\Attributes\EndsAt\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractEndsAtNotAuthorizedException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'ends_at';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_ENDS_AT_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
