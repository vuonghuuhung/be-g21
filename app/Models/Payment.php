<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'amount', 'response_code', 'transaction_no'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
