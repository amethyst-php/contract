<?php

namespace Railken\LaraOre\Contract\Attributes\PaymentMethod\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractPaymentMethodNotAuthorizedException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'payment_method';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_PAYMENT_METHOD_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
