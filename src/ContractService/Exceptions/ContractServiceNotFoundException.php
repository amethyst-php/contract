<?php

namespace Railken\LaraOre\ContractService\Exceptions;

class ContractServiceNotFoundException extends ContractServiceException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'CONTRACTSERVICE_NOT_FOUND';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'Not found';
}
