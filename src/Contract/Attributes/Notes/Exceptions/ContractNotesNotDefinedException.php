<?php

namespace Railken\LaraOre\Contract\Attributes\Notes\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractNotesNotDefinedException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'notes';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_NOTES_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
