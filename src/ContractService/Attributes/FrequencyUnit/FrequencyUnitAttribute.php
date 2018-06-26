<?php

namespace Railken\LaraOre\ContractService\Attributes\FrequencyUnit;

use Railken\Laravel\Manager\Attributes\BaseAttribute;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\Tokens;

class FrequencyUnitAttribute extends BaseAttribute
{
    /**
     * Name attribute.
     *
     * @var string
     */
    protected $name = 'frequency_unit';

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
        Tokens::NOT_DEFINED    => Exceptions\ContractServiceFrequencyUnitNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\ContractServiceFrequencyUnitNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\ContractServiceFrequencyUnitNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\ContractServiceFrequencyUnitNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'contractservice.attributes.frequency_unit.fill',
        Tokens::PERMISSION_SHOW => 'contractservice.attributes.frequency_unit.show',
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
        return in_array($value, ['hours', 'days', 'weeks', 'months', 'years']);
    }

    /**
     * Retrieve default value.
     *
     * @param EntityContract $entity
     *
     * @return mixed
     */
    public function getDefault(EntityContract $entity)
    {
        return $entity->service ? $entity->service->frequency_unit : null;
    }
}
