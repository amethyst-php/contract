<?php

namespace Railken\LaraOre\Contract\Exceptions;

class ContractNotFoundException extends ContractException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_NOT_FOUND';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'Not found';
}
