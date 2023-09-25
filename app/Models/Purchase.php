<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ['date'];

    protected $appends = ['total_discount', 'grand_total', 'total_due'];


    /**
     * Get related products
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * get all product purchase
     * @return HasMany
     */
    public function productPurchases(): HasMany
    {
        return $this->hasMany(ProductPurchase::class);
    }

    /**
     * get all account from bank
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * get cash details
     * @return BelongsTo
     */
    public function cash(): BelongsTo
    {
        return $this->belongsTo(Cash::class);
    }



    /**
     * get total discount
     */
    public function getTotalDiscountAttribute()
    {

        return ($this->discount_type == 'percentage') ? (($this->subtotal) * $this->discount) / 100 : $this->discount;
    }

    /**
     * get grand total
     */
    public function getGrandTotalAttribute()
    {
        return ($this->subtotal) - $this->total_discount;
    }

    /**
     * get total due
     */
    public function getTotalDueAttribute()
    {
        return ($this->grand_total - $this->total_paid);
    }
}
