<?php

namespace Railken\LaraOre\Contract\Attributes\Currency\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractCurrencyNotAuthorizedException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'currency';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_CURRENCY_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
