<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes;

    // fillable
    protected $fillable = [
        'name',
        'mobile_no',
        'area_id',
        'balance',
        'address',
        'description',
    ];

    /**
     * Get customer area
     *
     * @return BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * get all payment
     * @return HasMany
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * get all payment
     * @return HasMany
     */
    public function monthlyRecharges(): HasMany
    {
        return $this->hasMany(MonthlyRecharge::class);
    }

}
