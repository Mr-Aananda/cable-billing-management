<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory,SoftDeletes;
    // fillable
    protected $fillable = [
        'name',
        'mobile',
        'image',
        'nid_number',
        'basic_salary',
        'address',
        'note'
    ];

    protected $appends = ['url', 'total_advance','total_advance_paid','total_advance_due'];

    /**
     * Get related subcategories
     *
     * @return HasMany
     */
    public function advances(): HasMany
    {
        return $this->hasMany(Advance::class);
    }

    /**
     * get user all salaries
     * @return HasMany
     */
    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }


    public function getUrlAttribute()
    {
        return Storage::url($this->image);
    }


    /**
     * get total advanced
     */
    public function getTotalAdvanceAttribute()
    {
        $_totalAdvance = 0;

        foreach ($this->advances as $advance) {

            $_totalAdvance += $advance->amount;
        }
        return $_totalAdvance;
    }

    /**
     * get total paid
     */
    public function getTotalAdvancePaidAttribute()
    {
        $_totalAdvancePaid = 0;

        foreach ($this->advances as $advance) {

            $_totalAdvancePaid += $advance->total_paid;
        }
        return $_totalAdvancePaid;
    }

    /**
     * get total paid
     */
    public function getTotalAdvanceDueAttribute()
    {
        $_totalAdvanceDue = 0;

        foreach ($this->advances as $advance) {

            $_totalAdvanceDue += $advance->total_due;
        }
        return $_totalAdvanceDue;
    }
}
