<?php

namespace Railken\LaraOre\Contract\Attributes\TaxId\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractTaxIdNotValidException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'tax_id';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_TAX_ID_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}
