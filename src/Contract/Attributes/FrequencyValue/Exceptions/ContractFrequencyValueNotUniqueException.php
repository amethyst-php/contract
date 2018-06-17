<?php

namespace Railken\LaraOre\Contract\Attributes\FrequencyValue\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractFrequencyValueNotUniqueException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'frequency_value';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_FREQUENCY_VALUE_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}
