<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'customer_id',
        'product_id',	
        'order_date',
        'total_amount',
        'payment_method',
        'status',	
        'qr_token',	
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
