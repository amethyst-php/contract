<?php

namespace Railken\LaraOre\ContractService\Exceptions;

class ContractServiceNotAuthorizedException extends ContractServiceException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACTSERVICE_NOT_AUTHORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
