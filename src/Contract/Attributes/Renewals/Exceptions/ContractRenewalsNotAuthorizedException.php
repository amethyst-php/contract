<?php

namespace Railken\LaraOre\Contract\Attributes\Renewals\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractRenewalsNotAuthorizedException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'renewals';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_RENEWALS_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
