<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advance extends Model
{
    use HasFactory,SoftDeletes;
    // fillable
    protected $fillable = [
        'date',
        'employee_id',
        'amount',
        'cash_id',
        'payment_type',
        'is_paid',
        'note',
    ];

    protected $dates = ['date'];
    protected $appends = ['total_paid', 'total_due'];

    /**
     * get all advance salary paid details from advaned salary details
     * @return HasMany
     */
    public function advancePaids(): HasMany
    {
        return $this->HasMany(AdvancePaids::class);
    }

    public function scopeUnpaid($query)
    {
        return $query->where('is_paid', 0);
    }

    public function getTotalPaidAttribute()
    {
        return $this->advancePaids->sum('advance_paid_amount');
    }

    public function getTotalDueAttribute()
    {
        return $this->amount - $this->advancePaids->sum('advance_paid_amount');
    }

    /**
     * get cash details
     * @return BelongsTo
     */
    public function cash(): BelongsTo
    {
        return $this->belongsTo(Cash::class);
    }

}
