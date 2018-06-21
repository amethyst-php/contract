<?php

namespace Railken\LaraOre\ContractService\Attributes\Id\Exceptions;

use Railken\LaraOre\ContractService\Exceptions\ContractServiceAttributeException;

class ContractServiceIdNotUniqueException extends ContractServiceAttributeException
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
    protected $code = 'CONTRACTSERVICE_ID_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}