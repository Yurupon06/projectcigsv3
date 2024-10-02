<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'order_id',
        'order_complement_id',
        'payment_date',	
        'amount',	
        'amount_given',	
        'change',	
        'qr_token',	
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function ordercomplement(){
        return $this->belongsTo(OrderComplement::class, 'order_complement_id');
    }
}
