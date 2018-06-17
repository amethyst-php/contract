<?php

namespace Railken\LaraOre\Contract\Attributes\Renewals\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractRenewalsNotValidException extends ContractAttributeException
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
    protected $code = 'CONTRACT_RENEWALS_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}
