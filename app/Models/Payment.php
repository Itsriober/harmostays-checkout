<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'property_name',
        'customer_name',
        'customer_email',
        'booking_details',
        'amount',
        'currency',
        'status',
        'payment_transaction_id',
        'paid_at',
    ];

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
