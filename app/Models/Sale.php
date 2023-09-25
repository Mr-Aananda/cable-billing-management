<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Sale extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ['date','active_date','expire_date'];

    protected $appends = ['package_price','total_product_price','total_discount', 'grand_total', 'total_due'];


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
     * Get customer package
     *
     * @return BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * get all productsale
     * @return HasMany
     */
    public function productSales(): HasMany
    {
        return $this->hasMany(ProductSale::class);
    }

    /**
     * get all account from bank
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * get cash details
     * @return BelongsTo
     */
    public function cash():BelongsTo
    {
        return $this->belongsTo(Cash::class);
    }

    /**
     * get all productsale
     * @return HasMany
     */
    public function monthlyRecharges(): HasMany
    {
        return $this->hasMany(MonthlyRecharge::class);
    }


    /**
     * get total discount
     */
    public function getPackagePriceAttribute()
    {
        return $this->package->price ?? 0;
    }

    /**
     * get total discount
     */
    public function getTotalProductPriceAttribute()
    {
        $_totalProductPrice = 0;

        foreach ($this->productSales as $productSale) {

            $_totalProductPrice += $productSale->sale_price *  $productSale->quantity;
        }
        return $_totalProductPrice;
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
