<?php

namespace Railken\LaraOre\Contract\Attributes\Id\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractIdNotDefinedException extends ContractAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'id';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_ID_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
