<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $fillable = [
        'order_complement_id',
        'complement_id',
        'quantity',
        'sub_total',	
    ];

    public function ordercomplement(){
        return $this->belongsTo(OrderComplement::class, 'order_complement_id');
    }
    public function complement(){
        return $this->belongsTo(Complement::class, 'complement_id');
    }
}
