<?php

namespace Railken\LaraOre\ContractService\Attributes\FrequencyUnit\Exceptions;

use Railken\LaraOre\ContractService\Exceptions\ContractServiceAttributeException;

class ContractServiceFrequencyUnitNotUniqueException extends ContractServiceAttributeException
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
    protected $code = 'CONTRACTSERVICE_FREQUENCY_UNIT_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}