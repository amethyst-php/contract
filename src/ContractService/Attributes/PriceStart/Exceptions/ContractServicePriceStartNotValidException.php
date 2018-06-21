<?php

namespace Railken\LaraOre\ContractService\Attributes\PriceStart\Exceptions;

use Railken\LaraOre\ContractService\Exceptions\ContractServiceAttributeException;

class ContractServicePriceStartNotValidException extends ContractServiceAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'price_start';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACTSERVICE_PRICE_START_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}