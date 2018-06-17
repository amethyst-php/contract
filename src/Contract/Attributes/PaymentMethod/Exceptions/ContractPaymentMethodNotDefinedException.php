<?php

namespace Railken\LaraOre\Contract\Attributes\PaymentMethod\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractPaymentMethodNotDefinedException extends ContractAttributeException
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
    protected $code = 'CONTRACT_PAYMENT_METHOD_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
