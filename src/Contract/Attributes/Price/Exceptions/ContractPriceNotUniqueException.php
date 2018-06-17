<?php

namespace Railken\LaraOre\Contract\Attributes\Price\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractPriceNotUniqueException extends ContractAttributeException
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
    protected $code = 'CONTRACT_PRICE_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}
