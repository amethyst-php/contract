<?php

namespace Railken\LaraOre\Contract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Illuminate\Support\Facades\Config;
use Railken\LaraOre\Customer\Customer;
use Railken\LaraOre\Tax\Tax;
use Railken\LaraOre\ContractService\ContractService;

class Contract extends Model implements EntityContract
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'code',
        'country',
        'locale',
        'currency',
        'tax_id',
        'notes',
        'payment_method',
        'renewals',
        'starts_at',
        'ends_at',
        'frequency_unit',
        'frequency_value',
        'last_bill_at',
        'next_bill_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'last_bill_at',
        'next_bill_at',
        'starts_at',
        'ends_at'
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fillable = array_merge($this->fillable, array_keys(Config::get('ore.contract.attributes')));
        $this->table = Config::get('ore.contract.table');
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(ContractService::class);
    }
}
