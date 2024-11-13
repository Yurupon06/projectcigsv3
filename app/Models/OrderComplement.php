<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderComplement extends Model
{
    use HasFactory;
    protected $table = 'order_complements';
    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_method',
        'status',
        'quantity',
        'qr_token',
        'snap_token',
        'receive_status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
