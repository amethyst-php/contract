<?php

namespace Railken\LaraOre\Contract\Attributes\Price\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractPriceNotDefinedException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'price';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_PRICE_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
