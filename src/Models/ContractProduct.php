<?php

namespace Railken\Amethyst\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Railken\Amethyst\Common\ConfigurableModel;
use Railken\Lem\Contracts\EntityContract;

/**
 * @property \DateTime $started_at
 * @property \DateTime $suspended_at
 * @property \DateTime $terminated_at
 * @property string    $status
 * @property Contract  $contract
 * @property Target    $target
 * @property Group     $group
 * @property Product   $product
 * @property int       $renewals
 */
class ContractProduct extends Model implements EntityContract
{
    use SoftDeletes, ConfigurableModel;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.contract.data.contract-product');
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    /**
     * Get all prices.
     */
    public function prices()
    {
        return $this->morphMany(Price::class, 'priceable');
    }
}
