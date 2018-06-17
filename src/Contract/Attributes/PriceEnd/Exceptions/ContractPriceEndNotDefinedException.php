<?php

namespace Railken\LaraOre\Contract\Attributes\PriceEnd\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractPriceEndNotDefinedException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'price_end';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_PRICE_END_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
