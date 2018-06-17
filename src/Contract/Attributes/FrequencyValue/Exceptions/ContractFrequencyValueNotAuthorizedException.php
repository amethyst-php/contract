<?php

namespace Railken\LaraOre\Contract\Attributes\FrequencyValue\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractFrequencyValueNotAuthorizedException extends ContractAttributeException
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
    protected $code = 'CONTRACT_FREQUENCY_VALUE_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
