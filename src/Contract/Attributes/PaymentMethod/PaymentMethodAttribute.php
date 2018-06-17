<?php

namespace Railken\LaraOre\Contract\Attributes\PaymentMethod;

use Railken\Laravel\Manager\Attributes\BaseAttribute;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\Tokens;
use Respect\Validation\Validator as v;
use Illuminate\Support\Facades\Config;

class PaymentMethodAttribute extends BaseAttribute
{
    /**
     * Name attribute.
     *
     * @var string
     */
    protected $name = 'payment_method';

    /**
     * Is the attribute required
     * This will throw not_defined exception for non defined value and non existent model.
     *
     * @var bool
     */
    protected $required = false;

    /**
     * Is the attribute unique.
     *
     * @var bool
     */
    protected $unique = false;

    /**
     * List of all exceptions used in validation.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_DEFINED    => Exceptions\ContractPaymentMethodNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\ContractPaymentMethodNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\ContractPaymentMethodNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\ContractPaymentMethodNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'contract.attributes.payment_method.fill',
        Tokens::PERMISSION_SHOW => 'contract.attributes.payment_method.show',
    ];

    /**
     * Is a value valid ?
     *
     * @param EntityContract $entity
     * @param mixed          $value
     *
     * @return bool
     */
    public function valid(EntityContract $entity, $value)
    {
        return in_array($value, Config::get('ore.contract.payment_methods'));
    }
}
