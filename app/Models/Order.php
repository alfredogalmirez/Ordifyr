<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'amount_cents',
        'status',
        'paymongo_checkout_session_id',
        'paymongo_payment_id'
    ];
}
