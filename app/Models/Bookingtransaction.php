<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookingtransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'customer_bank_name',
        'customer_bank_acount',
        'customer_bank_number',
        'booking_bank_number',
        'booking_trx_id',
        'proof',
        'quantity',
        'total_amount',
        'is-paid',
        'wokshop_id',
    ];

    public static function geneateUniqueTrxId()
    {
        $prefix = 'AKT';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function participants(): HasMany
    {
        return $this->hasMany(WorkshopParticipant::class);
    }
    public function wokshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }
}
