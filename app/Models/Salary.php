<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Salary extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['advance_paid_amount'];

    /**
     * @return BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * get salary details
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(SalaryDetails::class);
    }

    /**
     * @return BelongsTo
     */
    public function advance(): BelongsTo
    {
        return $this->belongsTo(Advance::class);
    }

    /**
     * get salary details
     * @return HasOne
     */
    public function advancePaid(): HasOne
    {
        return $this->hasOne(AdvancePaids::class);
    }

     /**
     * get cash details
     * @return BelongsTo
     */
    public function cash():BelongsTo
    {
        return $this->belongsTo(Cash::class);
    }

    public function getAdvancePaidAmountAttribute()
    {
        return $this->advancePaid->advance_paid_amount ?? 0;
    }


    /** scope start */
    /**
     * get user total advanced amount
     * @param Builder $query
     * @return Builder
     */
    public function scopeAddTotalSalaryPaidAmount(Builder $query): Builder
    {
        return $query->addSelect([
            'total_salary_paid' => SalaryDetails::selectRaw("IF(ISNULL(SUM(amount)), 0, SUM(amount))")
            ->whereColumn('salary_id', 'salaries.id')
        ]);
    }

    /** scope start */

}
