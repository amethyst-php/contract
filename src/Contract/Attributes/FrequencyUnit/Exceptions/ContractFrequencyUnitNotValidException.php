<?php

namespace Railken\LaraOre\Contract\Attributes\FrequencyUnit\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractFrequencyUnitNotValidException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'frequency_unit';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_FREQUENCY_UNIT_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}
