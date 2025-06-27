<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'booking_id', 'user_id', 'amount', 'currency', 'status', 'ipn_token', 'txid_in', 'txid_out'
    ];
}
