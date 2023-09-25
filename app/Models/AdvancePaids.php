<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvancePaids extends Model
{
    use HasFactory;
    protected $guarded = [];


    /**
     * get all advance salary paid details from advaned salary details
     * @return BelongsTo
     */
    public function advance(): BelongsTo
    {
        return $this->belongsTo(Advance::class);
    }
}
