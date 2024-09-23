<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_complements';
    protected $fillable = [
        'order_complement_id',
        'complement_id',
        'quantity',
        'sub_total',	
    ];

    public function order_complement(){
        return $this->belongsTo(User::class, 'order_complement_id');
    }
    public function complement(){
        return $this->belongsTo(User::class, 'complement_id');
    }
}
