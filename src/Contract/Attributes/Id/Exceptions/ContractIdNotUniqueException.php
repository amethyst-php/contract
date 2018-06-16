<?php

namespace Railken\LaraOre\Contract\Attributes\Id\Exceptions;

use Railken\LaraOre\Contract\Exceptions\ContractAttributeException;

class ContractIdNotUniqueException extends ContractAttributeException
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
    protected $code = 'CONTRACT_ID_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}
