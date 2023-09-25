<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'date',
        'employee_id',
        'amount',
        'expire_date',
        'cash_id',
        'payment_type',
        'note',
    ];

    protected $dates = ['date', 'expire_date'];

    /**
     * get all account from bank
     * @return BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->BelongsTo(Employee::class);
    }

    /**
     * Get related loan installment
     *
     * @return HasMany
     */
    public function loanInstallments(): HasMany
    {
        return $this->hasMany(LoanInstallment::class);
    }

    /**
     * get cash details
     * @return BelongsTo
     */
    public function cash(): BelongsTo
    {
        return $this->belongsTo(Cash::class);
    }


    /* ==== Local Scope Start ==== */

    /**
     * Add paid
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAddPaid(Builder $query): Builder
    {
        return $query->addSelect([
            'paid' => LoanInstallment::selectRaw("IF (ISNULL(SUM(amount)), 0, SUM(amount))")
            ->whereColumn('loan_id', 'loans.id')
        ]);
    }

    /**
     * Add due
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAddDue(Builder $query): Builder
    {
        return $query->addSelect([
            'due' => LoanInstallment::selectRaw("loans.amount - IF (ISNULL(SUM(amount)), 0, SUM(amount))")
            ->whereColumn('loan_id', 'loans.id'),
        ]);
    }
}
