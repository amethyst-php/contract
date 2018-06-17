<?php

namespace Railken\LaraOre\Contract\Attributes\TaxId\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractTaxIdNotDefinedException extends ContractAttributeException
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
    protected $code = 'CONTRACT_TAX_ID_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
