<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use HasFactory,SoftDeletes;
    // fillable
    protected $fillable = [
        'name',
        'note'
    ];

    /**
     * Get related subcategories
     *
     * @return HasMany
     */
    public function expenseSubcategories(): HasMany
    {
        return $this->hasMany(ExpenseSubcategory::class);
    }

    /**
     * Get associated expenses
     *
     * @return HasMany
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
