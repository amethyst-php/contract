<?php

namespace Railken\LaraOre\Contract\Attributes\Country;

use Railken\Laravel\Manager\Attributes\BaseAttribute;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\Tokens;

class CountryAttribute extends BaseAttribute
{
    /**
     * Name attribute.
     *
     * @var string
     */
    protected $name = 'country';

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
        Tokens::NOT_DEFINED    => Exceptions\ContractCountryNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\ContractCountryNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\ContractCountryNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\ContractCountryNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'contract.attributes.country.fill',
        Tokens::PERMISSION_SHOW => 'contract.attributes.country.show',
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
        try {
            (new \League\ISO3166\ISO3166())->alpha2($value);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
