<?php

namespace Railken\LaraOre\Contract\Attributes\Country\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractCountryNotValidException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'country';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_COUNTRY_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}
