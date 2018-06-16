<?php

namespace Railken\LaraOre\Contract\Exceptions;

class ContractNotAuthorizedException extends ContractException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACT_NOT_AUTHORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
