<?php

namespace Railken\LaraOre\Contract\Attributes\CustomerId\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractCustomerIdNotUniqueException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'customer_id';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_CUSTOMER_ID_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}