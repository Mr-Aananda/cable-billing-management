<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    // fillable
    protected $fillable = [
        'name',
        'model',
        'purchase_price',
        'previous_purchase_price',
        'sale_price',
        'stock_alert',
        'description',
    ];

    protected $appends = [
        'quantity',
        'total_product_quantity',
        'total_purchase_price',
        // 'average_purchase_price',
    ];


    /**
     * get all productsale
     * @return HasMany
     */
    public function productSales(): HasMany
    {
        return $this->hasMany(ProductSale::class);
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
     * @return HasMany Stock
     */
    public function stock():HasMany
    {
        return $this->hasMany(Stock::class);
    }



    /**
     * get total product quantity
     * @return int|mixed
     */
    public function getTotalProductQuantityAttribute()
    {
        return $this->stock()->sum('quantity');
    }

    // /**
    //  * get total product quantity
    //  * @return int|mixed
    //  */
    // public function getAveragePurchasePriceAttribute()
    // {
    //     return ($this->stock()->sum('average_purchase_price'));
    // }


    /**
     * get quantity
     * @return mixed
     */
    public function getQuantityAttribute()
    {
        return $this->total_product_quantity;
    }

    /**
     * get total purchase price
     * @return int|mixed
     */
    public function getTotalPurchasePriceAttribute()
    {
        return $this->total_product_quantity * $this->purchase_price;
    }

}
